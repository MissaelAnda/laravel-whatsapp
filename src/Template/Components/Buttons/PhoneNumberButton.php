<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

class PhoneNumberButton extends BaseButton
{
    const MAX_PHONE_NUMBER_LENGTH = 20;

    public string $phoneNumber;

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
            ...parent::toArray(),
            'phone_number' => $this->phoneNumber,
        ];
    }
}
