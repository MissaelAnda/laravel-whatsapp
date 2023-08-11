<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookEntry
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $accountId,
        public string $type,
        public array $data = [],
    ) {
        $this->afterBuild();
    }

    public static function build(string $accountId, string $type, array $data): static
    {
        return match ($type) {
            'messages' => new MessagesReceived($accountId, $type, $data),
            default => new self($accountId, $type, $data),
        };
    }

    protected function afterBuild()
    {
        // 
    }
}
