# Laravel API Builder
Quick and easy way of sending API requests through your Laravel application.

<p>
<a href="https://packagist.org/packages/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/packagist/v/codeofdigital/laravel-api-builder" alt="Latest Version on Packagist"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/github/v/release/codeofdigital/laravel-api-builder" alt="Latest Release on GitHub"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/github/workflow/status/codeofdigital/laravel-api-builder/run-tests" alt="Build Status"></a>
<a href="https://packagist.org/packages/codeofdigital/laravel-api-builder"><img src="https://img.shields.io/packagist/php-v/codeofdigital/laravel-api-builder" alt="PHP from Packagist"></a>
<a href="https://github.com/codeofdigital/laravel-api-builder/blob/master/LICENSE.md"><img src="https://img.shields.io/github/license/codeofdigital/laravel-api-builder" alt="GitHub license"></a>
</p>

## Overview
An API Builder class package that send API requests, and during the process, also logging API requests and response.

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

### Generate API Builder
To generate an API Builder class, simple just run this Artisan command:

```bash
php artisan make:api-builder YourClassName
```

By default, it will create a directory in your root project as `App\ApiBuilder\Builder\YourClassName.php`

## Usage
### Configuration
In order to use the API Builder class, there are a few things needed to configure, 
```base_url``` and an optional ```token``` in .env file.

```bash
API_BUILDER_BASE_URI="https://example.com"
API_BUILDER_TOKEN="Your API Token"
```

### Quick Start
The quickest way to get started using API Builder class is by using the snippet below.
By using `to()` and `send()` method, we can easily send requests.

The API Builder class uses `PendingRequest` so all the methods are available to use.

```php
use App\ApiBuilder\Builder\TestAPI;

$result = TestAPI::to('GET', '/posts')->send();
```

`to()` method will require two arguments, HTTP Methods and
the URL path (if applicable).

### Class Properties
The API Builder class provides different class property for initialize the API request easily without going
through a lot of changes during the runtime.

```php
use CodeOfDigital\ApiBuilder\ApiBuilder;

/**
 * @method static self to(string $method, string $path)
 * @method static self build(...$args)
 *
 * @see ApiBuilder
 */
class TestAPI extends ApiBuilder
{
    // This property, if set to true, will log request and response during runtime
    protected static $enableLogging = true;
    
    // This property will set the type of token used, e.g. Bearer, Public-API, etc.
    protected $authorizationType = null;

    // This property sets the API token, if applicable
    protected $token;
    
    // This property sets the base URL
    protected $baseUrl;
    
    // This property compiles all the request headers being used in the API call
    protected $headers = [];
    
    // This property, if set to true, will retrieve the data in object format, and array format if its false
    public static $asObject = true;
}
```

It's not necessary to use all the class properties, you can use it according to your preference.

### Methods
#### Override Initial Request
By default, the request headers are already formatted and can use it with ease. If you choose to override the `buildHeaders()`
function, you can do so in your API Builder class. Below is one of the snippet on how you can overwrite the function and 
add your own code:

```php
use CodeOfDigital\ApiBuilder\ApiBuilder;
use Illuminate\Http\Client\PendingRequest;

/**
 * @method static self to(string $method, string $path)
 * @method static self build(...$args)
 *
 * @see ApiBuilder
 */
class TestAPI extends ApiBuilder
{
    protected $authorizationType = null;

    protected function buildHeaders(PendingRequest $pendingRequest)
    {
        // Add your own codes here
        $pendingRequest->withToken('your-own-token');
        
        // More codes...
    }
}
```

#### Add Request Data & Query
When using the API Builder class, you can add your own request data and query parameters
easily using `buildData()` and `buildQuery()` functions. Below is one of the snippets on
how you can use these functions to call the API:

```php
use App\ApiBuilder\Builder\TestAPI;

class TestController {
    public function someMethods()
    {
        // Using buildData()
        $result = TestAPI::to('POST', '/posts')
            ->buildData([
                'name' => 'some name',
                'description' => 'some description',
                'content' => 'some content'
            ])->send();
            
        // Using buildQuery()
        $anotherResult = TestAPI::to('GET', '/posts')
            ->buildQuery([
                'sort' => 'name',
                'order' => 'asc',
                'page' => '2'
            ])->send();
    }
}
```

#### Override Logging Data Transformation
By default, the logging data has been formatted according to the migrations provided from the package.
If you were to add additional columns in the migrations, you may override the data formatting through
`transformApiLogging()` in your API Builder class. Below is one of the snippet on how you can override
the logging data transformation:

```php
use CodeOfDigital\ApiBuilder\ApiBuilder;
use Illuminate\Http\Client\PendingRequest;

/**
 * @method static self to(string $method, string $path)
 * @method static self build(...$args)
 *
 * @see ApiBuilder
 */
class TestAPI extends ApiBuilder
{
    protected $authorizationType = null;

    protected function transformApiLogging(array $data)
    {
        // Add your own codes here
        $data['column_one'] = 'do something here';
        $data['column_two'] = 'do more things';
        $data['column_three'] = 'format the data';
        
        // More codes...
        
        return $data;
    }
}
```

## Testing

To run the package's unit tests, run the following command:

```bash
composer run tests
```

## Contribution

If you wish to make any changes or improvements to the package, feel free to make a pull request.

Note: A contribution guide will be added soon.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.