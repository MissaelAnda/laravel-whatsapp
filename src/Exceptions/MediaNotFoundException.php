<?php

namespace MissaelAnda\Whatsapp\Exceptions;

class MediaNotFoundException extends \Exception
{
    public function __construct(string $url)
    {
        parent::__construct("The file '$url' was not found. The url might have expired, try refreshing the media.");
    }
}
