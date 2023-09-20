<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

class UrlButton extends BaseButton
{
    public string $url;

    public ?string $example;

    public function url(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function example(?string $example): static
    {
        $this->example = $example;
        return $this;
    }

    public function toArray()
    {
        $data = [
            ...parent::toArray(),
            'url' => $this->url,
        ];

        if ($this->example) {
            $data['example'] = [$this->example];
        }

        return $data;
    }
}
