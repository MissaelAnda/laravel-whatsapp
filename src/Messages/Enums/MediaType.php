<?php

namespace MissaelAnda\Whatsapp\Messages\Enums;

enum MediaType: string
{
    case Audio = 'audio';
    case Document = 'document';
    case Image = 'image';
    case Sticker = 'sticker';
    case Video = 'video';
}
