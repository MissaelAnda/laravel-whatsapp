<?php

namespace MissaelAnda\Whatsapp\Messages;

class TextMessage extends WhatsappMessage
{
    public const TYPE = 'text';

    public function __construct(
        public string $body,
        public bool $previewUrl = false,
    ) {
        //
    }

    public static function create(
        string $body = '',
        bool $previewUrl = false,
    ): static {
        return new static($body, $previewUrl);
    }

    public function body(string $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function previewUrl(bool $previewUrl = false): static
    {
        $this->previewUrl = $previewUrl;
        return $this;
    }

    public function toArray()
    {
        return [
            'text' => [
                'body' => $this->body,
                'preview_url' => $this->previewUrl,
            ],
        ];
    }
}
