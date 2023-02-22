<?php

namespace MissaelAnda\Whatsapp\Messages\Components;

use MissaelAnda\Whatsapp\Messages\Message;

class Currency implements Message
{
    public static function create(
        string $defaultValue = 'Currency',
        string $code = 'USD',
        string $amount = '100',
    ): static {
        return new static($defaultValue, $code, $amount);
    }

    public function __construct(
        public string $defaultValue,
        public string $code,
        public string $amount,
    ) {
        //
    }

    public function defaultValue(string $defaultValue): static
    {
        $this->$defaultValue = $defaultValue;
        return $this;
    }

    public function code(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function amount(string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }


    public function toArray()
    {
        return [
            'fallback_value' => $this->defaultValue,
            'code' => $this->code,
            'amount_100' => $this->amount,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
