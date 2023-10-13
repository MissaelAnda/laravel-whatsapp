<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

class Error
{
    public function __construct(
        public int $code,
        public string $title,
        public ?string $message = null,
        public ?string $details = null,
        public array $data = [],
    ) {
        //
    }
}
