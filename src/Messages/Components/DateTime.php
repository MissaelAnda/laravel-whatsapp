<?php

namespace MissaelAnda\Whatsapp\Messages\Components;

use MissaelAnda\Whatsapp\Messages\Message;

class DateTime implements Message
{
    public static function create(?\DateTime $dateTime = null, string $defaultValue = ''): static
    {
        return new static($dateTime, $defaultValue);
    }

    public function __construct(
        public ?\DateTime $dateTime,
        public string $defaultValue,
    ) {
        //
    }

    public function defaultValue(string $defaultValue): static
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function dateTime(\DateTime $dateTime): static
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function toArray()
    {
        return [
            'fallback_value' => $this->defaultValue,
            'timestamp' => $this->dateTime->getTimestamp(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
