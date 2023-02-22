<?php

namespace MissaelAnda\Whatsapp\Messages\Components;

use MissaelAnda\Whatsapp\Messages\Message;

/**
 * @property array<Message> $parameters
 */
class Header implements Message
{
    /**
     * @param  array<Message> $parameters
     */
    public static function create(array $parameters): static
    {
        return new static($parameters);
    }

    public function __construct(
        public array $parameters,
    ) {
        //
    }

    public function toArray()
    {
        return [
            'type' => 'header',
            'parameters' => array_map(fn ($param) => $param->toArray(), $this->parameters),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
