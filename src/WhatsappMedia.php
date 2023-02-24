<?php

namespace MissaelAnda\Whatsapp;

class WhatsappMedia
{
    public function __construct(
        public string $id,
        public ?string $url,
        public ?string $mime_type,
        public ?string $sha256,
        public ?string $file_size,
    ) {
        // 
    }
}
