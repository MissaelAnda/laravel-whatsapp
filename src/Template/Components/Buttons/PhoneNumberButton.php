<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

class PhoneNumberButton extends BaseButton
{
    const MAX_PHONE_NUMBER_LENGTH = 20;

    public string $text;

    public string $phoneNumber;

    public function text(string $text): static
    {
        if (strlen($text) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("Text must be $max characters maximum.");
        }

        $this->text = $text;
        return $this;
    }

    public function phoneNumber(string $phoneNumber): static
    {
        if (strlen($phoneNumber) > $max = static::MAX_PHONE_NUMBER_LENGTH) {
            throw new \InvalidArgumentException("Phone number must be $max characters maximum.");
        }

        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'text' => $this->text,
            'phone_number' => $this->phoneNumber,
        ];
    }
}
