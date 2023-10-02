<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

use Illuminate\Support\Carbon;

class Status
{
    public function __construct(
        public string $wamId,
        public string $status,
        public Carbon $timestamp,
        public string $recipientId,
        public string $conversationId,
        public string $conversationType,
        public bool $billable,
        public string $pricingModel,
        public string $pricingCategory,
    ) {
        // 
    }
}
