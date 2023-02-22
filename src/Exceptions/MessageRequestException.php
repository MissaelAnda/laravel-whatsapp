<?php

namespace MissaelAnda\Whatsapp\Exceptions;

use Illuminate\Http\Client\Response;

class MessageRequestException extends \Exception
{
    public ?int $subcode;

    public string $fbTraceId;

    public function __construct(Response $response)
    {
        parent::__construct($response->json('error.message'), $response->json('error.code'));
        $this->subcode = $response->json('error.error_subcode');
        $this->fbTraceId = $response->json('error.fbtrace_id');
    }
}
