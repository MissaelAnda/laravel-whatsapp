<?php

namespace MissaelAnda\Whatsapp;

use MissaelAnda\Whatsapp\Exceptions\MessageRequestException;
use Illuminate\Http\Client\Response as ClientResponse;

class MessageResponse
{
    public function __construct(
        public string $id,
        public array $contacts,
    ) {
        //
    }

    public static function build(ClientResponse $response): static
    {
        if ($response->successful()) {
            return new static($response->json('messages.0.id'), $response->json('contacts'));
        } else {
            throw new MessageRequestException($response);
        }
    }
}
