
# Sparrow SMS Integration Package

The **Sparrow SMS Integration Package** provides a simple and easy way to send SMS messages in your Laravel applications. With this package, you can integrate Sparrow SMS services into your Laravel project, manage SMS configurations, and interact with the Sparrow SMS API.

## Installation

To install the package, run the following command in your Laravel project:

```bash
composer require bibekshrestha/sparrow-sms
```

## Service Provider

### Automatic Discovery

Laravel uses **Package Auto-Discovery**, so the service provider will be automatically discovered when you install the package. You do not need to manually add the provider in most cases.

### Manual Discovery

If auto-discovery does not work for any reason, you can manually add the service provider to your `config/app.php` file. Add the following line to the `providers` array:

```php
'providers' => [
    // Other providers...
    BibekShrestha\SparrowSms\SparrowSmsServiceProvider::class,
],
```
### Laravel Version Compatibility
- Laravel 8.x, 9.x, 10.x

## Configuration

After installing the package, publish the configuration file using the following Artisan command:

```bash
php artisan vendor:publish --tag=sparrow-sms
```

This will create a `sparrow-sms.php` file in your `config` directory. Open this file and add your **Sparrow SMS** credentials.

```php
return [
    'token' => env('SPARROW_SMS_TOKEN'),
    'from' => env('SPARROW_SMS_FROM', 'TheAlert'),
    'url' => env('SPARROW_SMS_URL'),
    'credit_url' => env('SPARROW_SMS_CREDIT_URL'),
    'enable_logging' => env('SPARROW_SMS_ENABLE_LOGGING', false),
];
```

Make sure to set the following values in your `.env` file:

```env
SPARROW_SMS_ENABLE_LOGGING=true
SPARROW_SMS_TOKEN=your_api_token
SPARROW_SMS_URL= https://api.sparrowsms.com/v2/sms/
SPARROW_SMS_CREDIT_URL=https://api.sparrowsms.com/v2/credit/
```

## Example Usage

### Sending to a Single Recipient

```php
use SparrowSms;

$data = [
    'recipient_number' => '1234567890', // Single recipient number
    'message' => 'Hello, this is a test message.',
];

SparrowSms::send($data);
```

### Sending to Multiple Recipients

```php
use SparrowSms;

$data = [
    'recipient_numbers' => ['recipient_phone_number_1', 'recipient_phone_number_2'], // Multiple recipient numbers
    'message' => 'Hello, this is a test message to multiple recipients.',
];

SparrowSms::sendBulk($data);
```

## Error Handling

- The function checks if both `recipient_number` and `message` are provided in the `$data` array. If not, an exception is thrown.
- If the API request fails, the function logs the error and throws an exception with the error message.

## License

This package is open-source and available under the [MIT License](LICENSE).

## Contributing

We welcome contributions to improve this package. If you'd like to contribute, please fork the repository and submit a pull request with your changes.
