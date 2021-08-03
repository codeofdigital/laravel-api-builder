# Laravel API Builder
Quick and easy way of sending API requests through your Laravel application.

<p>
<a href="https://packagist.org/packages/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/packagist/v/codeofdigital/laravel-api-builder" alt="Latest Version on Packagist"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/github/v/release/codeofdigital/laravel-api-builder" alt="Latest Release on GitHub"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/github/workflow/status/codeofdigital/laravel-api-builder/run-tests" alt="Build Status"></a>
<a href="https://packagist.org/packages/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/packagist/php-v/codeofdigital/laravel-api-builder" alt="PHP from Packagist"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder/blob/master/LICENSE.md"><img src="https://img.shields.io/github/license/codeofdigital/laravel-api-builder" alt="GitHub license"></a>
</p>

## Installation

### Requirements
The package has been developed and tested to work with the following requirements:

- PHP 7.2 and above
- Laravel 7.0 and above

API Builder package is dependent on Laravel's [HTTP Client](https://laravel.com/docs/8.x/http-client) class. 
Therefore, any Laravel version that is below 7.0 will not work.

### Install the Package
You can install the package via Composer:

```bash
composer require codeofdigital/laravel-api-builder
```

### Publish Config and Migrations
You can then publish the package's config file and database migrations file
with the following command:

```bash
php artisan vendor:publish --provider="CodeOfDigital\ApiBuilder\ApiBuilderServiceProvider"
```

### Database Migration
This package contains one migration file that adds ```api_logs``` logging table.
To run the migration, simply run the following command:

```bash
php artisan migrate
```