# Flow PHP SDK

The Flow PHP library provides convenient access to the Flow API from
applications written in the PHP language. It includes a pre-defined set of
classes for API resources that initialize themselves dynamically from API
responses which makes it compatible with a wide range of versions of the Flow
API.

## Requirements
PHP 8.0 and later.

## Composer

You can install the sdk via [Composer](http://getcomposer.org). Run the following command:
```bash
composer require up2date/flow-php-sdk
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started
Create a Flow client with configuration:

```php
Flow::setApiKey('10|x1lf89YRu4YVQEP7rHcnWA6YdHlGgl3nj7fAykGL');
Flow::setApiBase('https://flow.up2date.ro/api');
$flow = new \Up2date\FlowPhpSdk\FlowClient();
```

## Customers
Create a customer
```php
try {
    $customer = $flow->customers->create([
        'email' => 'john.doe@example.com',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'countryCode' => 40,
        'phone' => '723534609'
    ]);
    echo $customer;
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage();
}
```
Find a customer by email address
```php
try {
    $customer = $flow->customers->findOne([
        'email' => 'john.doe@example.com'
    ]);
    echo $customer;
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage();
}
```
Find a customer by phone number
```php
try {
    $customer = $flow->customers->findOne([
        'phone' => '723512322'
    ]);
    echo $customer;
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage();
}
```
## Loyalty
Get the loyalty rules
```php
try {
    $loyaltyRules = $flow->loyalty->getRules();
    echo $loyaltyRules;
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage()."\n";
}
```
Add loyalty points from amount
```php
try {
    $loyaltyParams = [
        'total' => 100, // Amount in the default currency
        'details' => 'Bonus points'
    ];

    $customer = $customer->addLoyaltyFromAmount($loyaltyParams);
    
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage()."\n";
}
```
Remove loyalty points from amount
```php
try {
    $loyaltyParams = [
        'total' => 100,
        'points' => 20,
        'details' => 'Spend points'
    ];

    $customer = $customer->removeLoyaltyFromAmount($loyaltyParams);
    
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage()."\n";
}
```
Calculate loyalty points from amount
```php
try {
    $params = [
        'total' => 100
    ];

    $points = $flow->loyalty->calculate($params);
    echo $points->data;
    
} catch (Up2date\FlowPhpSdk\Exception\ApiErrorException $exception) {
    echo $exception->getMessage()."\n";
}
```