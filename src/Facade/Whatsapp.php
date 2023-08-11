<?php

namespace MissaelAnda\Whatsapp\Facade;

use MissaelAnda\Whatsapp\Whatsapp as ConcreteWhatsapp;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array send(string|array<string> $phones, \MissaelAnda\Whatsapp\WhatsappMessage $message)
 * @method static \MissaelAnda\Whatsapp\Whatsapp numberId(string $numberId)
 * @method static \MissaelAnda\Whatsapp\Whatsapp numberName(string $name)
 * @method static \MissaelAnda\Whatsapp\Whatsapp defaultNumber()
 * @method static bool markRead(string $messageId)
 * @method static \MissaelAnda\Whatsapp\WhatsappMedia|string uploadMedia(string $file, string $type = null, bool $retrieveAllData = true)
 * @method static \MissaelAnda\Whatsapp\WhatsappMedia getMedia(string $mediaId, bool $download = false)
 * @method static bool deleteMedia(\MissaelAnda\Whatsapp\WhatsappMedia|string $id)
 * @method static \MissaelAnda\Whatsapp\WhatsappMedia downloadMedia(string|\MissaelAnda\Whatsapp\WhatsappMedia $media)
 * @method static \MissaelAnda\Whatsapp\BusinessProfile getProfile()
 * @method static bool updateProfile(array|\MissaelAnda\Whatsapp\BusinessProfile $data)
 */
class Whatsapp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'whatsapp';
    }

    public static function from(?string $numberId, ?string $token): ConcreteWhatsapp
    {
        return new ConcreteWhatsapp($numberId, $token);
    }
}
