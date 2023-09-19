<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MissaelAnda\Whatsapp\MessageResponse;

class MessageSent
{
    use Dispatchable, SerializesModels;

    public function __construct(public MessageResponse $response)
    {
        // 
    }
}
