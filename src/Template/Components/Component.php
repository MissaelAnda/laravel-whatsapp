<?php

namespace MissaelAnda\Whatsapp\Template\Components;

use MissaelAnda\Whatsapp\WhatsappData;

abstract class Component extends WhatsappData
{
    public function type(): string
    {
        return strtoupper(class_basename($this));
    }
}
