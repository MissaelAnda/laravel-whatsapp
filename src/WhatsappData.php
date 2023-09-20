<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class WhatsappData implements Arrayable, JsonSerializable
{
    public static function make(): static
    {
        return new static;
    }

    /**
     * @throws \MissaelAnda\Whatsapp\Exceptions\MalformedPayloadException
     */
    public static abstract function build(array $data): static;

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
