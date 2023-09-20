<?php

namespace MissaelAnda\Whatsapp\Template\Components;

class Buttons extends Component
{
    public array $buttons = [];

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'buttons' => array_map('toArray', $this->buttons),
        ];
    }
}
