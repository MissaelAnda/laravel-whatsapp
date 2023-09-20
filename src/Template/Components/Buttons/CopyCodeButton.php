<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

use MissaelAnda\Whatsapp\WhatsappData;

class CopyCodeButton extends BaseButton
{
    const MAX_LENGTH = 15;

    public string $example;

    public function example(string $example): static
    {
        if (strlen($example) > $max = static::MAX_LENGTH) {
            throw new \InvalidArgumentException("The example must be $max maximum.");
        }

        $this->example = $example;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'example' => $this->example,
        ];
    }
}
