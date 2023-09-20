<?php

namespace MissaelAnda\Whatsapp\Template\Components;

class Footer extends Component
{
    public string $text;

    /**
     * Only for Authentication templates
     */
    public ?int $codeExpirationMinutes = null;

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function codeExpirationMinutes(?int $minutes): static
    {
        if ($minutes !== null && ($minutes < 1 || $minutes > 90)) {
            throw new \InvalidArgumentException('The code expiration must be between 1 and 90.');
        }

        $this->codeExpirationMinutes = $minutes;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'type' => $this->type(),
        ];

        if ($this->codeExpirationMinutes !== null) {
            $data['code_expiration_minutes'] = $this->codeExpirationMinutes;
        } else {
            $data['text'] = $this->text;
        }

        return $data;
    }
}
