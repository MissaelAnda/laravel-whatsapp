<?php

namespace MissaelAnda\Whatsapp\Messages;

use MissaelAnda\Whatsapp\Messages\Components\Contact;

class ContactsMessage extends WhatsappMessage
{
    public const TYPE = 'contacts';

    /**
     * @param  Contact[] $contacts
     */
    public function __construct(
        public array $contacts = [],
    ) {
        // 
    }

    public static function create(array $contacts = []): static
    {
        return new static($contacts);
    }

    public function addContact(Contact $contact): static
    {
        $this->contacts[] = $contact;

        return $this;
    }

    public function toArray()
    {
        return [
            'contacts' => array_map(fn ($i) => $i->toArray(), $this->contacts),
        ];
    }
}
