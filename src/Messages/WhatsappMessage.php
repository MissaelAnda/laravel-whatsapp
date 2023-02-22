<?php

namespace MissaelAnda\Whatsapp\Messages;

abstract class WhatsappMessage implements Message
{
    public const TYPE = self::TYPE;

    /**
     * The message to respond
     */
    public ?string $respondToMessageId = null;

    public function respondTo(?string $messageId): static
    {
        $this->respondToMessageId = $messageId;
        return $this;
    }

    public function getMessageType(): string
    {
        return static::TYPE;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
