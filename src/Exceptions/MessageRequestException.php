<?php

namespace MissaelAnda\Whatsapp\Exceptions;

use Illuminate\Http\Client\Response;

class MessageRequestException extends \Exception
{
    public array $error;

    public function __construct(Response $response)
    {
        $message = $response->json('error.message', match ($response->status()) {
            404 => 'Resource not found',
            429 => 'Too many requests',
            default => 'Error',
        });

        parent::__construct($message, $response->json('error.code'));
        $this->error = $response->json('error', []);
    }
}
