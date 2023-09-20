<?php

namespace MissaelAnda\Whatsapp\Template\Components\Buttons;

use MissaelAnda\Whatsapp\Utils;

class OtpButton extends BaseButton
{
    public OtpType $type;

    public ?string $text = null;

    /**
     * Only for <ONE_TAP> type.
     */
    public ?string $autofill = null;

    /**
     * Only for <ONE_TAP> type.
     * 
     * The name of your Android package.
     */
    public ?string $packageName = null;

    /**
     * Only for <ONE_TAP> type.
     * 
     * The signing key encryption of your app.
     */
    public ?string $signatureHash = null;

    public function oneTap(): static
    {
        $this->type = OtpType::OneTap;
        return $this;
    }

    public function copyCode(): static
    {
        $this->type = OtpType::CopyCode;
        return $this;
    }

    public function text(?string $text): static
    {
        if ($text !== null && strlen($text) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("The text must be $max maximum.");
        }

        $this->text = $text;
        return $this;
    }

    public function autofill(?string $autofill): static
    {
        if ($autofill !== null && strlen($autofill) > $max = static::MAX_TEXT_LENGTH) {
            throw new \InvalidArgumentException("The autofill must be $max maximum.");
        }

        $this->autofill = $autofill;
        return $this;
    }

    public function packageName(?string $packageName): static
    {
        $this->packageName = $packageName;
        return $this;
    }

    public function signatureHash(?string $signatureHash): static
    {
        $this->signatureHash = $signatureHash;
        return $this;
    }

    public function toArray()
    {
        $data = [
            'type' => $this->type(),
            'otp_type' => $this->type->value,
        ];

        Utils::fill($data, 'text', $this->text, true);

        if ($this->type === OtpType::OneTap) {
            Utils::fill($data, [
                'autofill' => $this->autofill,
                'package_name' => $this->packageName,
                'signature_hash' => $this->signatureHash,
            ], ignoreNull: true);
        }

        return $data;
    }
}
