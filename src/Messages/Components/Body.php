<?php

namespace MissaelAnda\Whatsapp\Messages\Components;

use MissaelAnda\Whatsapp\Messages\Message;

/**
 * @property array<Message> $parameters
 */
class Body implements Message
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
            'type' => 'body',
            'parameters' => $this->parameters,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
