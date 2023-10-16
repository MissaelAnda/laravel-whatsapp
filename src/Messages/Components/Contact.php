<?php

namespace MissaelAnda\Whatsapp\Messages\Components;

use Illuminate\Support\Carbon;
use MissaelAnda\Whatsapp\Messages\Message;
use MissaelAnda\Whatsapp\Utils;

class Contact implements Message
{
    /**
     * @param  Phone[] $phones
     * @param  Address[] $addresses
     * @param  Email[] $emails
     * @param  ContactUrl[] $urls
     */
    public function __construct(
        public string $formattedName,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $middleName = null,
        public ?string $suffix = null,
        public ?string $prefix = null,
        // ORG Object
        public ?string $company = null,
        public ?string $department = null,
        public ?string $orgTitle = null,
        // -----------
        public array $addresses = [],
        public ?Carbon $birthday = null,
        public array $emails = [],
        public array $phones = [],
        public array $urls = [],
    ) {
        //
    }

    public static function create(
        string $formattedName,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $middleName = null,
        ?string $suffix = null,
        ?string $prefix = null,
        ?string $company = null,
        ?string $department = null,
        ?string $orgTitle = null,
        array $addresses = [],
        ?Carbon $birthday = null,
        array $emails = [],
        array $phones = [],
        array $urls = [],
    ): static {
        return new static(
            $formattedName,
            $firstName,
            $lastName,
            $middleName,
            $suffix,
            $prefix,
            $company,
            $department,
            $orgTitle,
            $addresses,
            $birthday,
            $emails,
            $phones,
            $urls,
        );
    }

    public function addPhone(Phone $phone): static
    {
        $this->phones[] = $phone;
        return $this;
    }

    public function addAddress(Address $address): static
    {
        $this->addresses[] = $address;
        return $this;
    }

    public function addUrl(ContactUrl $url): static
    {
        $this->urls[] = $url;
        return $this;
    }

    public function addEmail(Email $email): static
    {
        $this->emails[] = $email;
        return $this;
    }

    /**
     * @param  Phone[] $phones
     */
    public function phones(array $phones): static
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * @param  Address[] $addresses
     */
    public function addresses(array $addresses): static
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @param  ContactUrl[] $urls
     */
    public function urls(array $urls): static
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * @param  Email[] $emails
     */
    public function emails(array $emails): static
    {
        $this->emails = $emails;
        return $this;
    }

    public function toArray()
    {
        $data = [];
        $data = Utils::fill($data, [
            'name.formatted_name' => $this->formattedName,
            'name.first_name' => $this->firstName,
            'name.last_name' => $this->lastName,
            'name.middle_name' => $this->middleName,
            'name.suffix' => $this->suffix,
            'name.prefix' => $this->prefix,

            'birthday' => $this->birthday?->format('Y-m-d'),

            'org.company' => $this->company,
            'org.department' => $this->department,
            'org.title' => $this->orgTitle,
        ]);

        if (count($this->addresses)) {
            $data['addresses'] = array_map(fn ($i) => $i->toArray(), $this->addresses);
        }

        if (count($this->phones)) {
            $data['phones'] = array_map(fn ($i) => $i->toArray(), $this->phones);
        }

        if (count($this->emails)) {
            $data['emails'] = array_map(fn ($i) => $i->toArray(), $this->emails);
        }

        if (count($this->urls)) {
            $data['urls'] = array_map(fn ($i) => $i->toArray(), $this->urls);
        }

        return $data;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
