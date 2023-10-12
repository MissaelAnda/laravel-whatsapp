<?php

namespace MissaelAnda\Whatsapp\Messages;

use MissaelAnda\Whatsapp\Messages\Enums\MediaType;

class MediaMessage extends WhatsappMessage
{
    public const TYPE = 'media';

    public static function create(
        MediaType $type = MediaType::Image,
        ?string $id = null,
        ?string $link = null,
        ?string $caption = null,
        ?string $filename = null,
    ): static {
        return new static(
            $type,
            $id,
            $link,
            $caption,
            $filename
        );
    }

    public function __construct(
        public MediaType $type = MediaType::Image,
        public ?string $id = null,
        public ?string $link = null,
        public ?string $caption = null,
        public ?string $filename = null,
    ) {
        //
    }

    public function getMessageType(): string
    {
        return $this->type->value;
    }

    public function type(MediaType $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function id(?string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function link(?string $link): static
    {
        $this->link = $link;
        return $this;
    }

    public function caption(?string $caption): static
    {
        $this->caption = $caption;
        return $this;
    }

    public function filename(?string $filename): static
    {
        $this->filename = $filename;
        return $this;
    }


    public function toArray()
    {
        $data = [];

        if ($this->link) {
            $data['link'] = $this->link;
        } else {
            $data['id'] = $this->id;
        }

        if (
            $this->caption &&
            $this->type !== MediaType::Audio &&
            $this->type !== MediaType::Sticker
        ) {
            $data['caption'] = $this->caption;
        }

        if ($this->filename && $this->type === MediaType::Document) {
            $data['filename'] = $this->filename;
        }

        return [$this->type->value => $data];
    }
}
