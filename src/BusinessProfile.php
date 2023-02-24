<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class BusinessProfile implements Arrayable, JsonSerializable
{
    public function __construct(
        public ?string $about,
        public ?string $address,
        public ?string $description,
        public ?string $email,
        public ?string $profilePictureUrl,
        public ?BusinessVertical $vertical,
        public ?array $websites,
    ) {
        $this->normalizeWebsites();
    }

    public static function build(array $data): static
    {
        return new static(
            $data['about'] ?? null,
            $data['address'] ?? null,
            $data['description'] ?? null,
            $data['email'] ?? null,
            $data['profile_picture_url'] ?? null,
            BusinessVertical::tryFrom($data['vertical'] ?? ''),
            $data['websites'] ?? null,
        );
    }

    public function toArray(): array
    {
        $this->normalizeWebsites();

        return [
            'about' => $this->about,
            'address' => $this->address,
            'description' => $this->description,
            'email' => $this->email,
            'profile_picture_url' => $this->profilePictureUrl,
            'vertical'  => $this->vertical?->value,
            'websites' => $this->websites,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    protected function normalizeWebsites()
    {
        if ($this->websites !== null && count($this->websites) > 2) {
            $this->websites = array_slice($this->websites, 0, 2);
        }
    }
}
