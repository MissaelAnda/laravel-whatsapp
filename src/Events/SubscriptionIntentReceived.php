<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionIntentReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $ip,
        public array $payload,
    ) {
        // 
    }
}
