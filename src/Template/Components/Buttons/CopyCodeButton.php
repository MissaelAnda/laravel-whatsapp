<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

use MissaelAnda\Whatsapp\WhatsappData;

class CopyCodeButton extends WhatsappData
{
    const TYPE = 'COPY_CODE';
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
            'type' => static::TYPE,
            'example' => $this->example,
        ];
    }
}
