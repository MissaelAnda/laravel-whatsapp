<?php

namespace MissaelAnda\Whatsapp\Exceptions;

class InvalidWebhookEntryException extends \Exception
{
    public function __construct(?string $object)
    {
        $object ??= 'none';
        parent::__construct("Expected 'whatsapp_business_account' object, got $object.");
    }
}
