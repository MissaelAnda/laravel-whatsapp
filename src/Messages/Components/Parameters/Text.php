<?php

namespace MissaelAnda\Whatsapp\Messages\Components\Parameters;

use MissaelAnda\Whatsapp\Messages\Message;

class Text implements Message
{
    public static function create(string $text = ''): static
    {
        return new static($text);
    }

    public function __construct(
        public string $text,
    ) {
        //
    }

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => 'text',
            'text' => str_replace(["\n", "\t", "\r"], ['\n', '\t', '\r'], $this->text),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
