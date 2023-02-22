# Whatsapp Business Cloud API for Laravel

A Laravel package for the [Whatsapp Business Cloud API](https://developers.facebook.com/docs/whatsapp/cloud-api).

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [License](#license)

## Installation

```bash
composer require missael-anda/laravel-whatsapp
```

## Configuration

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

### Supported messages
- [x] Text Message
- [x] Media Message
- [x] Template Message
- [x] Reaction Message
- [ ] Contacts Message
- [ ] Interactive Message
- [ ] Location Message

## License

This project is licensed under the [MIT License](LICENSE).
