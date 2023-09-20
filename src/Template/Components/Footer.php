<?php

namespace MissaelAnda\Whatsapp\Template\Components;

use MissaelAnda\Whatsapp\WhatsappData;

class Footer extends WhatsappData
{
    const TYPE = 'FOOTER';

    public string $text;

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => static::TYPE,
            'text' => $this->text,
        ];
    }
}
