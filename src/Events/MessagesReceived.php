<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use MissaelAnda\Whatsapp\Events\Metadata\Contact;
use MissaelAnda\Whatsapp\Events\Metadata\Message;
use MissaelAnda\Whatsapp\Utils;

class MessagesReceived extends WebhookEntry
{
    public string $phoneNumberId;
    public string $displayPhoneNumber;

    /**
     * @var Collection<Contact>
     */
    public Collection $contacts;

    /**
     * @var Collection<Message>
     */
    public Collection $messages;

    protected function afterBuild()
    {
        $this->phoneNumberId = Utils::extract($this->data, 'metadata.phone_number_id');
        $this->displayPhoneNumber = Utils::extract($this->data, 'metadata.display_phone_number');
        // TODO: extract errors object and statuses object if they are present

        $this->buildContacts();
        $this->buildMessages();
    }

    protected function buildContacts()
    {
        $this->contacts = collect(Utils::extract($this->data, 'contacts'))->map(fn ($contact) => new Contact(
            Utils::extract($contact, 'wa_id'),
            Utils::extract($contact, 'profile.name')
        ));
    }

    protected function buildMessages()
    {
        $this->messages = collect(Utils::extract($this->data, 'messages'))->map(fn ($message) => new Message(
            Utils::extract($message, 'id'),
            Utils::extract($message, 'from'),
            Carbon::createFromTimestamp(Utils::extract($message, 'timestamp')),
            $type = Utils::extract($message, 'type'),
            Utils::extract($message, $type),
        ));
    }
}
