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

    public function header(?Header $header): static
    {
        $this->header = $header;
        return $this;
    }

    public function body(?Body $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function footer(?Footer $footer): static
    {
        $this->footer = $footer;
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
                    ->toArray(),
            ],
        ];

        if ($this->namespace) {
            $data['namespace'] = $this->namespace;
        }

        return $data;
    }
}
