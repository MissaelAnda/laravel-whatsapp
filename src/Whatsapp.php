<?php

namespace MissaelAnda\Whatsapp;

use MissaelAnda\Whatsapp\Exceptions\MessageRequestException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MissaelAnda\Whatsapp\Messages\WhatsappMessage;

class Whatsapp
{
    public const WHATSAPP_API_URL = 'https://graph.facebook.com/v{{VERSION}}';
    public const WHATSAPP_MESSAGE_API = '{{NUMBER_ID}}/messages';
    public const WHATSAPP_API_VERSION = '16.0';

    protected readonly string $numberId;
    protected readonly string $token;

    public function __construct(string $numberId = null, string $token = null)
    {
        $this->token = $token ?? config('whatsapp.token');
        $this->numberId = $numberId ?? config('whatsapp.default_number_id');
    }

    public function numberId(string $numberId): static
    {
        if (empty($numberId)) {
            throw new \Exception("Invalid number ID provided.");
        }

        return new static($numberId);
    }

    public function token(string $token): static
    {
        if (empty($token)) {
            throw new \Exception("Invalid token provided.");
        }

        return new static(null, $token);
    }

    public function numberName(string $name): static
    {
        $phone = config("whatsapp.phones.$name");
        return $this->numberId($phone);
    }

    public function defaultNumber(): static
    {
        return $this->numberId(config('whatsapp.default_number_id'));
    }

    public function send(string|array $phones, WhatsappMessage $message)
    {
        if (is_string($phones) || count($phones) === 1) {
            return $this->sendMessage(Arr::wrap($phones)[0], $message);
        } else {
            return $this->sendMassMessage($phones, $message);
        }
    }

    protected function sendMessage(string $phone, WhatsappMessage $message): MessageResponse
    {
        $response = $this->request()->post($this->buildApiEndpoint('messages'), $this->buildMessage($phone, $message));

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

    protected function buildApiEndpoint(string $for): string
    {
        return Str::of(static::WHATSAPP_API_URL)
            ->replace('{{VERSION}}', static::WHATSAPP_API_VERSION)
            ->append('/', match ($for) {
                'messages' => static::WHATSAPP_MESSAGE_API,
            })
            ->replace('{{NUMBER_ID}}', $this->numberId);
    }
}
