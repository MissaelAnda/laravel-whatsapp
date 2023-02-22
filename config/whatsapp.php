<?php

return [
    /**
     * The whatsapp token to be used.
     */
    'token' => env('WHATSAPP_TOKEN'),

    /**
     * The default NUMBER ID used to send the messages.
     */
    'default_number_id' => env('WHATSAPP_NUMBER_ID'),

    /**
     * If you want to use other number id's you can add them here so you can call
     * `numberName` with the name you provide here and make it easier to change
     * the phone where the messages are sended.
     */
    'numbers' => [
        // 'fallback' => env('WHATSAPP_FALLBACK_NUMBER_ID'),
    ],
];
