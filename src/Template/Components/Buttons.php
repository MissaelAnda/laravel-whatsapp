<?php

namespace MissaelAnda\Whatsapp\Template\Components;

use MissaelAnda\Whatsapp\Template\Components\Buttons\BaseButton;
use MissaelAnda\Whatsapp\Template\Components\Buttons\CopyCodeButton;
use MissaelAnda\Whatsapp\Template\Components\Buttons\OtpButton;
use MissaelAnda\Whatsapp\Template\Components\Buttons\PhoneNumberButton;
use MissaelAnda\Whatsapp\Template\Components\Buttons\QuickReplyButton;
use MissaelAnda\Whatsapp\Template\Components\Buttons\UrlButton;

class Buttons extends Component
{
    /**
     * @var BaseButton[]
     */
    public array $buttons = [];

    /**
     * @param  BaseButton[] $buttons
     */
    public function buttons(array $buttons): static
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function copyCode(CopyCodeButton|array $copyCode): static
    {
        if (is_array($copyCode)) {
            $copyCode = CopyCodeButton::build($copyCode);
        }

        $this->buttons[] = $copyCode;
        return $this;
    }

    public function otp(OtpButton|array $otp): static
    {
        if (is_array($otp)) {
            $otp = OtpButton::build($otp);
        }

        $this->buttons[] = $otp;
        return $this;
    }

    public function phoneNumber(PhoneNumberButton|array $phoneNumber): static
    {
        if (is_array($phoneNumber)) {
            $phoneNumber = PhoneNumberButton::build($phoneNumber);
        }

        $this->buttons[] = $phoneNumber;
        return $this;
    }

    public function url(UrlButton|array $url): static
    {
        if (is_array($url)) {
            $url = UrlButton::build($url);
        }

        $this->buttons[] = $url;
        return $this;
    }

    public function quickReply(QuickReplyButton|array $quickReply): static
    {
        if (is_array($quickReply)) {
            $quickReply = QuickReplyButton::build($quickReply);
        }

        $this->buttons[] = $quickReply;
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'buttons' => array_map('toArray', $this->buttons),
        ];
    }
}
