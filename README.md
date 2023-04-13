# Health checks for Laravel & Lumen

[![Tests](https://github.com/brightfish-be/health-checks/actions/workflows/run-tests.yml/badge.svg?style=flat-square&label=Tests)](https://github.com/brightfish-be/health-checks/actions/workflows/run-tests.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/brightfish/health-checks.svg?style=flat-square&label=Version)](https://packagist.org/packages/brightfish/health-checks)
[![Total Downloads](https://img.shields.io/packagist/dt/brightfish/health-checks.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/brightfish/health-checks)

## Usage
Run all your registered checks from the command line:
```php 
php artisan health:check
```

Or make a HTTP request to the built-in `health` endpoint:
```bash
curl GET https://your.app/health
```

## Installation
Install the package with composer:
```bash
composer require brightfish/health-checks
```

Publish the config file:
```bash
php artisan vendor:publish --provider="Brightfish\HealthChecks\HealthServiceProvider" --tag="health-checks-config"
```

Create a custom health check class:
```php
namespace App\Health\MyCustomCheck;

class MyCustomCheck extends \Brightfish\HealthChecks\Checks\AbstractCheck
{
    public function run(): bool
    {
        return false;
    }

    public function getMessage(): string
    {
        return 'Error';
    }
}
```

Finally, list up the class in the config file: 
```php
return [
    'checks' => [
        \App\Health\MyCustomCheck::class,
    ],
];
```

## Testing
```bash
composer test
```

## Contributing
Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities
Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [Brightfish](https://github.com/brightfish-be)
- [All Contributors](../../contributors)

## License
GNU General Public License (GPL). Please see [License File](LICENSE.md) for more information.
