# Mailosaur SDK for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chrisreedio/laravel-mailosaur.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-mailosaur)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-mailosaur/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/chrisreedio/laravel-mailosaur/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-mailosaur/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/chrisreedio/laravel-mailosaur/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisreedio/laravel-mailosaur.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-mailosaur)

Thin Laravel integration for the official Mailosaur PHP SDK. This package registers a singleton `MailosaurClient` configured from your app’s config/ENV, and exposes it via a simple wrapper class and a facade so you can call the Mailosaur API anywhere in your app.

> The PHP usage patterns below are based on the Mailosaur docs: [Mailosaur PHP – Find an email](https://mailosaur.com/docs/languages/php#4-find-an-email-for-automated-testing).

## Requirements

- PHP ^8.3
- Laravel ^10 || ^11 || ^12

## Installation

```bash
composer require chrisreedio/laravel-mailosaur
```

Publish the config file:

```bash
php artisan vendor:publish --tag="laravel-mailosaur-config"
```

Set your environment variables (recommended):

```dotenv
MAILOSAUR_API_KEY=your_api_key
MAILOSAUR_SERVER_ID=your_server_id
# Optional (defaults to "${MAILOSAUR_SERVER_ID}.mailosaur.net")
MAILOSAUR_EMAIL_DOMAIN=your-domain.mailosaur.net
```

The published config `config/mailosaur.php` reads from these ENV keys:

```php
return [
    'api_key' => env('MAILOSAUR_API_KEY'),
    'server_id' => env('MAILOSAUR_SERVER_ID'),
    'domain' => env('MAILOSAUR_EMAIL_DOMAIN', env('MAILOSAUR_SERVER_ID').'.mailosaur.net'),
];
```

## How it works

- The service provider creates a singleton instance of `MailosaurClient` using `config('mailosaur.api_key')`.
- It wraps the client in `ChrisReedIO\Mailosaur\Mailosaur`, which also exposes your `serverId` and `domain` from config.
- A facade alias `Mailosaur` is registered for convenience.

## Usage

You can access the same singleton three ways. Choose what fits your style:

1) Facade (convenient):

```php
use ChrisReedIO\Mailosaur\Facades\Mailosaur; // or use the alias: use Mailosaur;

$client = Mailosaur::client();
$messages = Mailosaur::messages();
$serverId = Mailosaur::serverId();
$domain = Mailosaur::domain();
```

2) Dependency Injection:

```php
use ChrisReedIO\Mailosaur\Mailosaur;

public function __construct(private Mailosaur $mailosaur) {}

public function __invoke()
{
    $client = $this->mailosaur->client();
}
```

3) Container helper:

```php
$mailosaur = app(\ChrisReedIO\Mailosaur\Mailosaur::class);
```

## Common examples

### Find an email (wait for the next matching message)

```php
use ChrisReedIO\Mailosaur\Facades\Mailosaur;
use Mailosaur\Models\SearchCriteria;

$criteria = new SearchCriteria();
$criteria->sentTo = 'anything@' . Mailosaur::domain();

$message = Mailosaur::messages()->get(Mailosaur::serverId(), $criteria);

// e.g. assert subject
// expect($message->subject)->toBe('My example email');
```

### Wait with custom timeout and only include messages received after test start

```php
use ChrisReedIO\Mailosaur\Facades\Mailosaur;
use Mailosaur\Models\SearchCriteria;

$testStart = new \DateTime();

$criteria = new SearchCriteria();
$criteria->sentTo = 'anything@' . Mailosaur::domain();

// timeout in ms, receivedAfter as DateTime
$message = Mailosaur::messages()->get(
    Mailosaur::serverId(),
    $criteria,
    10_000,
    $testStart
);
```

### Generate a random email address for the server

```php
use ChrisReedIO\Mailosaur\Facades\Mailosaur;

$emailAddress = Mailosaur::client()->servers->generateEmailAddress(Mailosaur::serverId());
// e.g. "bgwqj@SERVER_ID.mailosaur.net"
```

### Delete all messages on the server

```php
use ChrisReedIO\Mailosaur\Facades\Mailosaur;

Mailosaur::client()->messages->deleteAll(Mailosaur::serverId());
```

For many more operations (attachments, forwarding, replying, etc.), see the official Mailosaur PHP docs: [Mailosaur PHP – Find an email](https://mailosaur.com/docs/languages/php#4-find-an-email-for-automated-testing).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Chris Reed](https://github.com/chrisreedio)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
