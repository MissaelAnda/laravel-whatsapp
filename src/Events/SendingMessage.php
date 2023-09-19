<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MissaelAnda\Whatsapp\Messages\WhatsappMessage;

class SendingMessage
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $numberId,
        public array $phones,
        public WhatsappMessage $message,
    ) {
        // 
    }
}
