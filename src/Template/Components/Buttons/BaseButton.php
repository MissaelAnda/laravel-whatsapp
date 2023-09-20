<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

use MissaelAnda\Whatsapp\WhatsappData;

abstract class BaseButton extends WhatsappData
{
    const TYPE = 'BUTTON';
    const MAX_TEXT_LENGTH = 25;

    public function type(): string
    {
        return str(class_basename($this))->before('Button')->snake()->upper();
    }
}
