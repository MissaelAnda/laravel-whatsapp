<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MissaelAnda\Whatsapp\Exceptions\MessageRequestException;

class MessageFailed
{
    use Dispatchable, SerializesModels;

    public function __construct(public MessageRequestException $exception)
    {
        // 
    }
}
