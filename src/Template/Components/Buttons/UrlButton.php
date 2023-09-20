<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

class UrlButton extends BaseButton
{
    public string $text;

    public string $url;

    public ?string $example;

    public function text(string $text): static
    {
        if (strlen($text) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("Text must be $max characters maximum.");
        }

        $this->text = $text;
        return $this;
    }

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
            'type' => $this->type(),
            'text' => $this->text,
            'url' => $this->url,
        ];

        if ($this->example) {
            $data['example'] = [$this->example];
        }

        return $data;
    }
}
