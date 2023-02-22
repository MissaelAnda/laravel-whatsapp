<?php

namespace MissaelAnda\Whatsapp\Messages\Components\Parameters;

use MissaelAnda\Whatsapp\Messages\Components\Currency as ComponentsCurrency;

class Currency extends ComponentsCurrency
{
    public function toArray()
    {
        return [
            'type' => 'currency',
            'currency' => parent::toArray(),
        ];
    }
}
