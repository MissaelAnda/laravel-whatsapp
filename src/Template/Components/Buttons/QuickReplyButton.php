<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

class QuickReplyButton extends BaseButton
{
    public string $text;

    public function text(string $text): static
    {
        if (strlen($text) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("Text must be $max characters maximum.");
        }

        $this->text = $text;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'text' => $this->text,
        ];
    }
}
