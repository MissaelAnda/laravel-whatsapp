<?php

namespace MissaelAnda\Whatsapp\Messages;

use Illuminate\Support\Arr;

class ContactsMessage extends WhatsappMessage
{
    public const TYPE = 'contacts';

    public function __construct(
        protected array $contacts = []
    ) {
        // 
    }

    public function toArray()
    {
        return [
            'contacts' => Arr::map($this->contacts, 'toArray'),
        ];
    }
}
