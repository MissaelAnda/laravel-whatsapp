<?php

namespace MissaelAnda\Whatsapp\Messages;

use MissaelAnda\Whatsapp\Messages\Components\Body;
use MissaelAnda\Whatsapp\Messages\Components\Button;
use MissaelAnda\Whatsapp\Messages\Components\Currency;
use MissaelAnda\Whatsapp\Messages\Components\DateTime;
use MissaelAnda\Whatsapp\Messages\Components\Footer;
use MissaelAnda\Whatsapp\Messages\Components\Header;

/**
 * @property array<Button> $buttons
 */
class TemplateMessage extends WhatsappMessage
{
    public const TYPE = 'template';

    /**
     * @param  Button[] $buttons
     */
    public static function create(
        string $name = '',
        string $language = '',
        ?string $namespace = null,
        ?Header $header = null,
        ?Body $body = null,
        ?Footer $footer = null,
        ?Currency $currency = null,
        ?DateTime $datetime = null,
        array $buttons = [],
    ) {
        return new static($name, $language, $namespace, $header, $body, $footer, $currency, $datetime, $buttons);
    }

    public function __construct(
        public string $name,
        public string $language,
        public ?string $namespace = null,
        public ?Header $header = null,
        public ?Body $body = null,
        public ?Footer $footer = null,
        public ?Currency $currency = null,
        public ?DateTime $datetime = null,
        public array $buttons = [],
    ) {
        //
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function namespace(string $namespace): static
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function language(string $language): static
    {
        $this->language = $language;
        return $this;
    }

    public function header(Header|array|null $header): static
    {
        if (is_array($header)) {
            $this->header = Header::create($header);
        } else {
            $this->header = $header;
        }

        return $this;
    }

    public function body(Body|array|null $body): static
    {
        if (is_array($body)) {
            $this->body = Body::create($body);
        } else {
            $this->body = $body;
        }

        return $this;
    }

    public function footer(Footer|array|null $footer): static
    {
        if (is_array($footer)) {
            $this->footer = Footer::create($footer);
        } else {
            $this->footer = $footer;
        }

        return $this;
    }

    public function currency(?Currency $currency = null): static
    {
        $this->currency = $currency;
        return $this;
    }

    public function dateTime(?DateTime $datetime = null): static
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @param  Button[] $buttons
     */
    public function buttons(array $buttons): static
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'template' => [
                'name' => $this->name,
                'language' => ['code' => $this->language],
                'components' => collect([
                    $this->header,
                    $this->body,
                    $this->footer,
                    $this->currency,
                    $this->datetime,
                    ...$this->buttons
                ])
                    ->whereNotNull()
                    ->values()
                    ->toArray(),
            ],
        ];

        if ($this->namespace) {
            $data['namespace'] = $this->namespace;
        }

        return $data;
    }
}
