<?php

return [
    /**
     * The whatsapp token to be used.
     */
    'token' => env('WHATSAPP_TOKEN'),

    /**
     * The whatsapp's app secret code. Required for webhook request signature verification.
     */
    'secret' => env('WHATSAPP_SECRET'),

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

    'webhook' => [
        /**
         * Wether to enable the webhook routes
         */
        'enabled' => env('WHATSAPP_WEBHOOK_ENABLED', true),

        /**
         * The webhook path, by default "/whatsapp/webhook"
         */
        'path' => env('WHATSAPP_WEBHOOK_PATH', 'whatsapp'),

        /**
         * The webhook verification token.
         * For more information check https://developers.facebook.com/docs/graph-api/webhooks/getting-started#verification-requests
         */
        'verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN'),

        /**
         * Wether the webhook request signature should be verified or not.
         */
        'verify_signature' => env('WHATSAPP_WEBHOOK_SIGNATURE_VERIFY', false),
    ],
];
