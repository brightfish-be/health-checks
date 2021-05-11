# Health checks for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brightfish/health-checks.svg?style=flat-square)](https://packagist.org/packages/brightfish/health-checks)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/brightfish/health-checks/run-tests?label=tests)](https://github.com/brightfish/health-checks/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/brightfish/health-checks/Check%20&%20fix%20styling?label=code%20style)](https://github.com/brightfish/health-checks/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/brightfish/health-checks.svg?style=flat-square)](https://packagist.org/packages/brightfish/health-checks)

## Installation

```bash
composer require brightfish/health-checks
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Brightfish\HealthChecks\HealthServiceProvider" --tag="health-checks-config"
```

## Usage

Add your check classes to the service provider.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Brightfish](https://github.com/brightfish-be)
- [All Contributors](../../contributors)

## License

GNU General Public License (GPL). Please see [License File](LICENSE.md) for more information.
