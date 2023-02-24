# Whatsapp Business Cloud API for Laravel

A Laravel package for the [Whatsapp Business Cloud API](https://developers.facebook.com/docs/whatsapp/cloud-api).

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
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

Whatsapp::send('13333333333', TextMessage::create('Answer to your message')
    ->respondTo('wamid.91n23...'));
```

and you can mark messages as read:

```php
Whatsapp::markRead('wamid.91n23...');
```

Bye default the messages will be sended from the `default_number_id`, if you want to use other you can use `Whatsapp::numberId()` or add the alias to the config's `numbers` list and use `Whatsapp::numberName()`.

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
Whatsapp::getMedia(string $mediaId): \MissaelAnda\Whatsapp\WhatsappMedia
Whatsapp::deleteMedia(\MissaelAnda\Whatsapp\WhatsappMedia|string $id): bool
Whatsapp::downloadMedia(string|\MissaelAnda\Whatsapp\WhatsappMedia $media): string
```

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
        return "$this->phone_code$this->phone";
    }
}
```

Now just create a notification that implements the `toWhatsapp()` function:

```php
//...
use MissaelAnda\Whatsapp\Messages\TextMessage;
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
        return TextMessage::create("Your verification code is {$this->code}.");
    }
}
```

Now you can send whatsapp notifications:

```php
$user->notify(new VerificationCode('12345678'));
```

## License

This project is licensed under the [MIT License](LICENSE).
