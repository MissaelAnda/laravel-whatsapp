<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

use MissaelAnda\Whatsapp\WhatsappData;

abstract class BaseButton extends WhatsappData
{
    const TYPE = 'BUTTON';
    const MAX_TEXT_LENGTH = 25;

    public string $text;

    public function type(): string
    {
        return str(class_basename($this))->before('Button')->snake()->upper();
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'text' => $this->text,
        ];
    }

    public function text(string $text): static
    {
        if (strlen($text) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("Text must be $max characters maximum.");
        }

        $this->text = $text;
        return $this;
    }
}
