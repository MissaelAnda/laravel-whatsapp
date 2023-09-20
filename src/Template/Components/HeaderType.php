<?php

namespace MissaelAnda\Whatsapp\Template\Components;

enum HeaderType: string
{
    case Text = 'TEXT';
    case Media = 'MEDIA';
    case Location = 'LOCATION';
}
