<?php

namespace MissaelAnda\Whatsapp\Messages\Components\Parameters;

use MissaelAnda\Whatsapp\Messages\Message;

class Document implements Message
{
    public static function create(
        ?string $id = null,
        ?string $link = null,
        ?string $filename = null
    ): static {
        return new static($id, $link, $filename);
    }

    public function __construct(
        public ?string $id = null,
        public ?string $link = null,
        public ?string $filename = null,
    ) {
        //
    }

    public function id(?string $id = null): static
    {
        $this->id = $id;
        return $this;
    }

    public function link(?string $link = null): static
    {
        $this->link = $link;
        return $this;
    }

    public function filename(?string $filename = null): static
    {
        $this->filename = $filename;
        return $this;
    }

    public function toArray()
    {
        $data = $this->link ? ['link' => $this->link] : ['id' => $this->id];

        if ($this->filename) {
            $data['filename'] = $this->filename;
        }

        return [
            'type' => 'document',
            'document' => $data,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
