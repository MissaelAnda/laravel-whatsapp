# Whatsapp Business Cloud API for Laravel

A Laravel package for the [Whatsapp Business Cloud API](https://developers.facebook.com/docs/whatsapp/cloud-api).

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Media](#media)
  - [Business profile](#business-profile)
- [Notification Channel](#notification-channel)
- [License](#license)

## Installation

```bash
composer require missael-anda/laravel-whatsapp
```

## Configuration

You will need to set the `WHATSAPP_TOKEN` and `WHATSAPP_NUMBER_ID` values in your .env.

For further configuration, please see [config/whatsapp.php](config/whatsapp.php). You can modify the configuration
by copying it to your local `config` directory or by defining the environment variables used in the config file:

```bash
php artisan vendor:publish --provider="MissaelAnda\Whatsapp\WhatsappServiceProvider" --tag=config
```

## Usage

You can send a messages to a single or multiple clients.

```php
use MissaelAnda\Whatsapp\Messages;

Whatsapp::send('13333333333', Messages\TemplateMessage::create()
    ->name('one_time_password')
    ->language('en_US')
    ->body(Messages\Components\Body::create([
        Messages\Components\Parameters\Text::create('000000'),
    ])));
```

You can also respond to other messages in the conversation with any message type (except reaction message):

```php
use MissaelAnda\Whatsapp\Messages\TextMessage;

Whatsapp::send('13333333333', TextMessage::create('Answer to your message')->respondTo('wamid.91n23...'));
```

and you can mark messages as read:

```php
Whatsapp::markRead('wamid.91n23...');
```

By default the messages will be sent from the `default_number_id`, if you want to use other you can use `Whatsapp::numberId()` or add the alias to the config's `numbers` list and use `Whatsapp::numberName()`.
Also you can set the token manually with `Whatsapp::token()` or you can set both the token and numberId you can use `Whatsapp::client()`

### Supported messages

- [x] Text Message
- [x] Media Message
- [x] Template Message
- [x] Reaction Message
- [ ] Contacts Message
- [ ] Interactive Message
- [ ] Location Message

### Media

You can also [manage media](https://developers.facebook.com/docs/whatsapp/cloud-api/reference/media) with:

```php
Whatsapp::uploadMedia(string $file, string $type = null, bool $retrieveAllData = true): \MissaelAnda\Whatsapp\WhatsappMedia|string
Whatsapp::getMedia(string $mediaId, bool $download = false): \MissaelAnda\Whatsapp\WhatsappMedia
Whatsapp::deleteMedia(\MissaelAnda\Whatsapp\WhatsappMedia|string $id): bool
Whatsapp::downloadMedia(string|\MissaelAnda\Whatsapp\WhatsappMedia $media): \MissaelAnda\Whatsapp\WhatsappMedia
```

### Business Profile

There are also two ways to manage the number's business profile:

```php
Whatsapp::getProfile(): \MissaelAnda\Whatsapp\BusinessProfile
Whatsapp::updateProfile(\MissaelAnda\Whatsapp\BusinessProfile|array $data): bool
```

## Webhooks

Whatsapp allows you to subscribe to [webhooks](https://developers.facebook.com/docs/whatsapp/cloud-api/guides/set-up-webhooks) to receive notifications and most importantly messages from your customers. Both subscriptions and notifications are handled out of the box in the route whatsapp/webhook (you can change the path with the WHATSAPP_WEBHOOK_PATH env variable).

When a you register the webhook meta will send a subscription, this requires a verification token that you set, you will need to set it with WHATSAPP_WEBHOOK_VERIFY_TOKEN env setting.
When receiving a subscription intent a `MissaelAnda\Whatsapp\Events\SubscriptionIntentReceived` event will be fired, if the request is successful the `MissaelAnda\Whatsapp\Events\SuccessfullySubscribed` event will fire too.

On the other hand notifications will trigger a `MissaelAnda\Whatsapp\Events\WebhookReceived` event with all the payload, if you want to protect this route verifying the sha256 signature you must set the WHATSAPP_WEBHOOK_SIGNATURE_VERIFY to true and the WHATSAPP_SECRET to your whatsapp's app secret.

If the payload is invalid a `MissaelAnda\Whatsapp\Events\UnprocessableWebhookPayload` event will be fired with the exception describing the error.

If you want to know when a specific notification is fired you can subscribe to this events:

- `MissaelAnda\Whatsapp\Events\WebhookEntry` generic entry
- `MissaelAnda\Whatsapp\Events\MessagesReceived` for the `messages` entry

## Notification Channel

This library has support for channel notification, just add the `routeNotificationForWhatsapp()` function to the Notifiable user (it can return a single whatsapp_id or an array of them):

```php
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @return string|array
     */
    public function routeNotificationForWhatsapp(): string|array
    {
        return "{$this->phone_code}{$this->phone}";
    }
}
```

Now just create a notification that implements the `toWhatsapp()` function:

```php
//...
use MissaelAnda\Whatsapp\Messages\TemplateMessage;
use MissaelAnda\Whatsapp\Messages\Components\Parameters;
use MissaelAnda\Whatsapp\WhatsappChannel;

class VerificationCode extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected string $code)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WhatsappChannel::class];
    }

    /**
     * Get the message representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \MissaelAnda\Whatsapp\Messages\WhatsappMessage
     */
    public function toWhatsapp($notifiable)
    {
        return TemplateMessage::create('one_time_password')
            ->language('en_US')
            ->body([
                Parameters\Text::create('123456'),
            ]);
    }
}
```

Now you can send whatsapp notifications:

```php
$user->notify(new VerificationCode('12345678'));
```

## Configuration file

```php
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
```

## Missing features

- Register/deregister/validate new phone numbers

## License

This project is licensed under the [MIT License](LICENSE).
