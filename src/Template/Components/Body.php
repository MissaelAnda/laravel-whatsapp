<?php

namespace MissaelAnda\Whatsapp\Template\Components;

class Body extends Component
{
    public string $text;

    public array $examples;

    /**
     * Only for Authentication templates
     */
    public ?bool $addSecurityRecommendation = null;

    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function examples(array $examples): static
    {
        $this->examples = $examples;
        return $this;
    }

    public function addSecurityRecommendation(?bool $addSecurityRecommendation): static
    {
        $this->addSecurityRecommendation = $addSecurityRecommendation;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'type' => $this->type(),
        ];

        if ($this->addSecurityRecommendation !== null) {
            $data['add_security_recommendation'] = $this->addSecurityRecommendation;
        } else {
            $data['text'] = $this->text;
            if (count($this->examples)) {
                $data['examples'] = ['body_text' => [$this->examples]];
            }
        }

        return $data;
    }
}
