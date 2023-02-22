<?php

namespace MissaelAnda\Whatsapp\Messages;

class ReactionMessage extends WhatsappMessage
{
    public const TYPE = 'reaction';

    public static function create(string $messageId = '', string $emoji = ''): static
    {
        return new static($messageId, $emoji);
    }

    public function __construct(
        public string $messageId,
        public string $emoji,
    ) {
        //
    }

    public function messageId(string $messageId): static
    {
        $this->messageId = $messageId;
        return $this;
    }

    public function emoji(string $emoji): static
    {
        $this->emoji = $emoji;
        return $this;
    }

    public function toArray()
    {
        return [
            'reaction' => [
                'message_id' => $this->messageId,
                'emoji' => $this->emoji,
            ],
        ];
    }
}
