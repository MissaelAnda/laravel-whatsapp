<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

class Contact
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
        // 
    }
}
