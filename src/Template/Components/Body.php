<?php

namespace MissaelAnda\Whatsapp\Template\Components;

class Body extends Component
{
    public string $text;

    public array $examples;

    public function text(string $text): static
    {
        $this->text = $text;
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
            'type' => $this->type(),
            'text' => $this->text,
        ];

        if (count($this->examples)) {
            $data['examples'] = ['body_text' => [$this->examples]];
        }

        return $data;
    }
}
