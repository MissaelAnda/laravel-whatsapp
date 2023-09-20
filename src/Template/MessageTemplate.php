<?php

namespace MissaelAnda\Whatsapp\Template;

use Illuminate\Contracts\Support\Arrayable;

class MessageTemplate implements Arrayable
{
    protected static $allowedLangs = [
        'af', 'sq', 'ar', 'az', 'bn',
        'bg', 'ca', 'zh_CN', 'zh_HK',
        'zh_TW', 'hr', 'cs', 'da', 'nl',
        'en', 'en_GB', 'es_LA', 'et', 'fil',
        'fi', 'fr', 'de', 'el', 'gu', 'he',
        'hi', 'hu', 'id', 'ga', 'it', 'ja',
        'kn', 'kk', 'ko', 'lo', 'lv', 'lt',
        'mk', 'ms', 'mr', 'nb', 'fa', 'pl',
        'pt_BR', 'pt_PT', 'pa', 'ro', 'ru',
        'sr', 'sk', 'sl', 'es', 'es_AR', '
        es_ES', 'es_MX', 'sw', 'sv', 'ta',
        'te', 'th', 'tr', 'uk', 'ur', 'uz', 'vi',
    ];

    public ?int $id = null;

    public string $name;

    public Category $category;

    public string $lang;

    public ?TemplateStatus $status = null;

    public bool $allowCategoryChange = true;

    public array $components = [];

    public static function make(): static
    {
        return new static;
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function category(Category|string $category): static
    {
        $this->category = is_string($category) ? Category::from(strtoupper($category)) : $category;
        return $this;
    }

    public function lang(string $lang): static
    {
        if (!in_array($lang, static::$allowedLangs)) {
            throw new \InvalidArgumentException("The language $lang is not allowed, check https://developers.facebook.com/docs/whatsapp/business-management-api/message-templates/supported-languages.");
        }

        $this->lang = $lang;
        return $this;
    }

    public function components(array $components): static
    {


        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
