<?php

namespace MissaelAnda\Whatsapp\Exceptions;

class InvalidMessageException extends \Exception
{
    public function __construct($instance)
    {
        $type = gettype($instance);
        parent::__construct("Expected WhatsappMessage, got $type.");
    }
}
