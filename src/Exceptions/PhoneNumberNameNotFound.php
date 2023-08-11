<?php

namespace MissaelAnda\Whatsapp\Exceptions;

class PhoneNumberNameNotFound extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("The phone number with name $name was not found in the config file.");
    }
}
