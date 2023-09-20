<?php

namespace MissaelAnda\Whatsapp\Template\Components;

use MissaelAnda\Whatsapp\WhatsappData;

class Header extends WhatsappData
{
    const TYPE = 'HEADER';

    public string $text;

    public HeaderType $type;

    public array $examples = [];

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function type(string|HeaderType $type): static
    {
        $this->type = is_string($type) ? HeaderType::from(strtoupper($type)) : $type;
        return $this;
    }

    public function examples(array $examples): static
    {
        $this->examples = $examples;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'type' => self::TYPE,
            'format' => $this->type->value,
        ];

        if ($this->type === HeaderType::Text) {
            $data['text'] = $this->text;
            if (count($this->examples)) {
                $data['example'] = ['header_text' =>  $this->examples];
            }
        } else if ($this->type === HeaderType::Media) {
            $data['example'] = ['header_handle' => $this->examples];
        }

        return $data;
    }
}
