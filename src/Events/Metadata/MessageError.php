<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

use MissaelAnda\Whatsapp\Utils;

class MessageError
{
    public function __construct(
        public string $title,
        public string $code,
        public ?string $message,
        public ?array $data,
    ) {
        // 
    }

    /**
     * @return static[]
     */
    public static function fromPayload(array $payload): array
    {
        return collect($payload['errors'] ?? [])->map(fn () => new static(
            Utils::extract($payload, 'title'),
            Utils::extract($payload, 'code'),
            $payload['message'] ?? null,
            $payload['error_data'] ?? null,
        ))->all();
    }
}
