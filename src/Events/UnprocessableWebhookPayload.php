<?php

namespace MissaelAnda\Whatsapp\Events;

use Exception;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnprocessableWebhookPayload
{
    use Dispatchable, SerializesModels;

    public function __construct(public Exception $e)
    {
        // 
    }
}
