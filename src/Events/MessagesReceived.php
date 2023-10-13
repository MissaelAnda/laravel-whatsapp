<?php

namespace MissaelAnda\Whatsapp\Events;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use MissaelAnda\Whatsapp\Events\Metadata\Contact;
use MissaelAnda\Whatsapp\Events\Metadata\Error;
use MissaelAnda\Whatsapp\Events\Metadata\Message;
use MissaelAnda\Whatsapp\Events\Metadata\MessageContext;
use MissaelAnda\Whatsapp\Events\Metadata\MessageError;
use MissaelAnda\Whatsapp\Events\Metadata\Status;
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

    /**
     * @var Collection<Status>
     */
    public Collection $statuses;

    protected function afterBuild()
    {
        $this->phoneNumberId = Utils::extract($this->data, 'metadata.phone_number_id');
        $this->displayPhoneNumber = Utils::extract($this->data, 'metadata.display_phone_number');
        // TODO: extract errors object and statuses object if they are present

        $this->buildContacts();
        $this->buildMessages();
        $this->buildStatuses();
    }

    protected function buildStatuses()
    {
        $this->statuses = collect(Utils::extract($this->data, 'statuses', false))->map(fn ($status) => new Status(
            Utils::extract($status, 'id'),
            Utils::extract($status, 'status'),
            Carbon::createFromTimestamp(Utils::extract($status, 'timestamp')),
            Utils::extract($status, 'recipient_id'),
            Utils::extract($status, 'conversation.id', false),
            Utils::extract($status, 'conversation.origin.type', false),
            Utils::extract($status, 'pricing.billable', false),
            Utils::extract($status, 'pricing.pricing_model', false),
            Utils::extract($status, 'pricing.category', false),
            collect(Utils::extract($status, 'errors', false))->map(fn ($error) => new Error(
                Utils::extract($error, 'code'),
                Utils::extract($error, 'title'),
                Utils::extract($error, 'message', false) ?: null,
                Utils::extract($error, 'error_data.details', false) ?: null,
                $error,
            ))->all(),
        ));
    }

    protected function buildContacts()
    {
        $this->contacts = collect(Utils::extract($this->data, 'contacts', false))->map(fn ($contact) => new Contact(
            Utils::extract($contact, 'wa_id'),
            Utils::extract($contact, 'profile.name')
        ));
    }

    protected function buildMessages()
    {
        $this->messages = collect(Utils::extract($this->data, 'messages', false))->map(fn ($message) => new Message(
            Utils::extract($message, 'id'),
            Utils::extract($message, 'from'),
            Carbon::createFromTimestamp(Utils::extract($message, 'timestamp')),
            $type = Utils::extract($message, 'type'),
            MessageContext::fromPayload($message),
            Utils::extract($message, $type),
            MessageError::fromPayload($message),
        ));
    }
}
