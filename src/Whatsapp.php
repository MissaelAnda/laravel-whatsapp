<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use MissaelAnda\Whatsapp\Exceptions\MessageRequestException;
use MissaelAnda\Whatsapp\Exceptions\MediaNotFoundException;
use MissaelAnda\Whatsapp\Exceptions\PhoneNumberNameNotFound;
use MissaelAnda\Whatsapp\Messages\WhatsappMessage;

class Whatsapp
{
    public const WHATSAPP_API_URL = 'https://graph.facebook.com/v{{VERSION}}';
    public const WHATSAPP_MESSAGE_API = 'messages';
    public const WHATSAPP_API_VERSION = '17.0';

    public function __construct(
        protected readonly ?string $numberId,
        protected readonly ?string $token,
    ) {
        // 
    }

    public function client(string $numberId, string $token): static
    {
        if (empty($numberId)) {
            throw new \Exception('Invalid number ID provided.');
        }

        if (empty($token)) {
            throw new \Exception('Invalid token provided.');
        }

        return new static($numberId, $token);
    }

    public function numberId(string $numberId): static
    {
        if (empty($numberId)) {
            throw new \Exception('Invalid number ID provided.');
        }

        return new static($numberId, $this->token);
    }

    public function token(string $token): static
    {
        if (empty($token)) {
            throw new \Exception('Invalid token provided.');
        }

        return new static($this->numberId, $token);
    }

    public function numberName(string $name): static
    {
        $phone = Config::get("whatsapp.phones.$name");

        if ($phone === null) {
            throw new PhoneNumberNameNotFound($name);
        }

        return $this->numberId($phone, $this->token);
    }

    public function defaultNumber(): static
    {
        return $this->numberId(Config::get('whatsapp.default_number_id'));
    }

    /**
     * @return MessageResponse|array<MessageResponse|MessageRequestException>
     * 
     * @throws MessageRequestException
     */
    public function send(string|array $phones, WhatsappMessage $message): MessageResponse|array
    {
        if (is_string($phones) || count($phones) === 1) {
            return $this->sendMessage(Arr::wrap($phones)[0], $message);
        } else {
            return $this->sendMassMessage($phones, $message);
        }
    }

    public function markRead(string $messageId): bool
    {
        $response = $this->sendRequest($this->buildApiEndpoint('messages'), 'post', [
            'messaging_product' => 'whatsapp',
            'status' => 'read',
            'message_id' => $messageId,
        ]);

        return $response->json('success');
    }

    public function uploadMedia(string $file, string $type = null, bool $retrieveAllData = true): WhatsappMedia|string
    {
        if ($type === null && !Storage::fileExists($file)) {
            throw new FileNotFoundException("The file $file doesn't exists.");
        }

        $response = $this->request()
            ->attach(
                'file',
                $type === null ? Storage::get($file) : $file,
                $type === null ? $file : Str::random()
            )
            ->post($this->buildApiEndpoint('media'), [
                'messaging_product' => 'whatsapp',
                'type' => $type ?? Storage::mimeType($file),
            ]);

        if (!$response->successful()) {
            throw new MessageRequestException($response);
        }

        $id = $response->json('id');

        if ($retrieveAllData) {
            return $this->getMedia($id);
        }
        return $id;
    }

    public function getMedia(string $mediaId, bool $download = false): WhatsappMedia
    {
        $response = $this->sendRequest($this->buildApiEndpoint($mediaId, false), 'get');

        $media = new WhatsappMedia(
            $response->json('id'),
            $response->json('url'),
            $response->json('mime_type'),
            $response->json('sha256'),
            $response->json('file_size'),
        );

        if ($download) {
            $media->download();
        }

        return $media;
    }

    public function deleteMedia(WhatsappMedia|string $id): bool
    {
        if ($id instanceof WhatsappMedia) $id = $id->id;
        $response = $this->sendRequest($this->buildApiEndpoint($id, false), 'delete');

        return $response->json('success');
    }

    /**
     * @throws MediaNotFoundException
     */
    public function downloadMedia(string|WhatsappMedia $media): WhatsappMedia
    {
        if ($media instanceof WhatsappMedia) {
            $url = $media->url;
        } else {
            if (filter_var($media, FILTER_VALIDATE_URL) === false) {
                throw new \Exception("Expected media url.");
            }
            $url = $media;
        }

        if (empty($url)) {
            throw new \InvalidArgumentException('The url can not be empty.');
        }

        $response = Http::withToken($this->token)->get($url);

        if (!$response->ok()) {
            throw new MediaNotFoundException($url);
        }

        if ($media instanceof WhatsappMedia) {
            $media->source = $response->body();
        } else {
            $media = new WhatsappMedia(
                null,
                $url,
                $response->header('Content-Type'),
                null,
                $response->header('Content-Length'),
                $response->body(),
            );
        }

        return $media;
    }

    public function getProfile(): BusinessProfile
    {
        $response = $this->sendRequest($this->buildApiEndpoint('whatsapp_business_profile'), 'get');

        return BusinessProfile::build($response->json('data'));
    }

    public function updateProfile(array|BusinessProfile $data): bool
    {
        $response = $this->sendRequest(
            $this->buildApiEndpoint('whatsapp_business_profile'),
            'post',
            array_merge((array)$data, ['messaging_product' => 'whatsapp'])
        );

        return $response->json('success');
    }

    protected function sendMessage(string $phone, WhatsappMessage $message): MessageResponse
    {
        $response = $this->sendRequest($this->buildApiEndpoint('messages'), 'post', $this->buildMessage($phone, $message));

        return MessageResponse::build($response);
    }

    /**
     * @param  string[] $phones
     * @return array<MessageResponse|MessageRequestException>
     */
    protected function sendMassMessage(array $phones, WhatsappMessage $message)
    {
        collect($this->request()->pool(function (Pool $pool) use ($phones, $message) {
            $url = $this->buildApiEndpoint('messages');

            foreach ($phones as $phone) {
                $pool->post($url, $this->buildMessage($phone, $message));
            }
        }))->map(function ($response) {
            try {
                return MessageResponse::build($response);
            } catch (MessageRequestException $e) {
                return $e;
            }
        })->toArray();
    }

    protected function buildMessage(string $phone, WhatsappMessage $message): array
    {
        $data = array_merge([
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $phone,
            'type' => $message->getMessageType(),
        ], $message->toArray());

        if ($message->respondToMessageId) {
            $data['context'] = ['message_id' => $message->respondToMessageId];
        }

        return $data;
    }

    protected function request(): PendingRequest
    {
        return Http::acceptJson()->withToken($this->token);
    }

    protected function buildApiEndpoint(string $for, bool $withNumberId = true): string
    {
        return Str::of(static::WHATSAPP_API_URL)
            ->replace('{{VERSION}}', static::WHATSAPP_API_VERSION)
            ->when($withNumberId, fn ($str) => $str->append('/', $this->numberId))
            ->append('/', $for);
    }

    protected function sendRequest(string $url, string $method, array $data = []): Response
    {
        /** @var Response */
        $response = $this->request()->{strtolower($method)}($url, $data);

        if (!$response->successful()) {
            throw new MessageRequestException($response);
        }

        return $response;
    }
}
