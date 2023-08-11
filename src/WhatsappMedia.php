<?php

namespace MissaelAnda\Whatsapp;

use MissaelAnda\Whatsapp\Facade\Whatsapp;

class WhatsappMedia
{
    public function __construct(
        public ?string $id,
        public ?string $url,
        public ?string $mime_type,
        public ?string $sha256,
        public ?string $file_size,
        public ?string $source = null,
    ) {
        // 
    }

    public function download(): static
    {
        Whatsapp::downloadMedia($this);

        return $this;
    }

    public function downloaded(): bool
    {
        return $this->source !== null;
    }

    public function isValid(): bool
    {
        if (!$this->download()) {
            return false;
        }

        return hash_equals($this->sha256, hash('sha256', $this->source));
    }
}
