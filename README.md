[![Clear architecture][clear-architecture-image]][clear-architecture-url]
---

# Qodehub's PHP-SDK for Slydepay.

 ## Minimum requirements
This library requires PHP >=5.4.0 <=~7.1. I recommend using the latest available version of PHP as a matter of principle and report issues so for continious.

This package can be used in either a [Normal php app](#php) or a [Laravel app](#laravel)

<a name="laravel"></a>
## Installing Slypday in a Laravel app

Install Slydepay with [composer](https://getcomposer.org/doc/00-intro.md):

```bash
$ composer require qodehub/slydepay-php-rest-api
```

> In Laravel 5.5, [service providers and aliases are automatically registered](https://laravel.com/docs/5.5/packages#package-discovery). If you're using Laravel 5.5 or newer version, skip ahead directly to step 3.

Once the composer installation completes, you can add the service provider and alias the facade. Open `config/app.php`, and make the following changes:

1) Add a new item to the `providers` array:

```php
	Qodehub\Slydepay\Laravel\PackageServiceProvider::class,
```

2) Add a new item to the `aliases` array:

```php
	'Slydepay' => Qodehub\Slydepay\Laravel\Facades\Slydepay,
```

    This part is optional. If you don't want to use the facade, you can skip step 2.

3) Now, publish config into your app's `config` directory, by running the following command:

```php 
	artisan vendor:publish --provider="Qodehub\Slydepay\Laravel\PackageServiceProvider"
```

#### Facade

Whenever you use the `Slydepay` facade in your code, remember to add this line to your namespace imports at the top of the file:

```php
	use Qodehub\Slydepay\Laravel\Facades\Slydepay;
```

For more information about Laravel Facades, refer to [the Laravel documentation](https://laravel.com/docs/5.5/facades).

<a name="php"></a>
## Installing Slydepay in a PHP app

1) Install Slydepay with [composer](https://getcomposer.org/doc/00-intro.md):

```bash
	$ composer require qodehub/slydepay-php-rest-api
```

2) Create a slydepay configuration instance like so using your slidepay merchant account information (email-or-phone and key):

```php
    $config = new \Qodehub\Slydepay\Config($merchantEmailOrMobileNumber, $merchantKey);

 ```

    This configuration can then be injected into a slydepay instance.

#### Config

The config can be injected into the slydepay instance using one of the following patterns:

```php 
	$slydepay = Slydepay::make()->injectConfig($config); 
```
    
    or 

```php 
	$slydepay = new Slydepay($config); 
```
    
    or 

```php 
	$slydepay = new Slydepay($merchantEmailOrMobileNumber, $merchantKey); 
```


#### Namespace

Whenever you use the `Slydepay` without fascade in your code, remember to add this line to your namespace imports at the top of the file:

```php
	use Qodehub\SlydePay\SlydePay;
```

# Usage

Note: Each of the following instance asumes that you are using within a laravel app. The commented part of the code samples simply shows how to inject the config if not in a laravel app. Alternatively ne of the examples on the [Config section](#Config) can also be used. 

### List pay options
Retrieves a list of all possible payment options on Slydepay
```php
	SlydePay::listPayOPtions()
		// ->injectConfig($config)
		->run();
```

### Create invoice

Creates an invoice and sends back slydepay pay token.This web method assumes a simple scenario of passing total transaction amount without complex orderItems array to worry about. If you are used to the SOAP API then the orderItems array which is used can also been used for display purpose only. This returns useful details to enable your customer to complete the payment. One of them is the PayToken that should be used to append to the slydepay payment page url https://app.slydepay.com/paylive/detailsnew.aspx?pay_token. For example if the PayToken is PayTokenGUID the redirect url would be then : https://app.slydepay.com/paylive/detailsnew.aspx?pay_token=PayTokenGUID

```php
	Slydepay::createInvoice()
	    ->amount(100) // The amount the to bill the user.
	    ->orderCode(1)	//A unique order code.
	    // ->injectConfig($config)
	    ->run();
```

Required:
 - amount
 - orderCode

Optional:
 - description
 - orderItems

### Create and send invoice

Creates an invoice and sends back slydepay pay token . This is the same web method as the CreateInvoice method but the difference lies in the fact that this assumes that your the merchant wants us to send the invoice to the customer instead of your redirecting the user with the returned token to the slydepay payment url. This method takes few extra parameters in addition to CreateInvoice parameters. 
It is important to note that in case of Mobile Money payoption, the customer phone number becomes compulsory otherwise a email with the invoice is sent to your customer. When MTN Mobile Money is the payoption chosen by you or in a form provided to your customer will receive a bill prompt directly on his/her phone. 

- For MTN_MONEY, mobile bill prompt will only be sent if your customer has enough money in his/her wallet to cover the amount in your invoice

```php
	Slydepay::createAndSendInvoice()
		->amount(100) // The amount the to bill the user.
		->orderCode(1)	//A unique order code.
		->description('Some nasty description') // A description for the payment.
		->orderItems([]) // Items ordered.
		->payoption('mm') // A valid pay option.
		->sendInvoice(true) // Determine if invoice should be sent or not.
		->customerName('Victor') // The name of the customer.
		->customerEmail('iamovac@gmail.com') // The customer's email address.
		->from(12345) // The Phone number that will recieve this bill. 
		// ->injectConfig($config)
		->run();
```

Required: 
 - amount
 - orderCode
 - payOption
 - sendInvoice
 - customerName
 - customerEmail
 - customerMobileNumber (from)

Optional:
 - description
 - orderItems

### Send invoice

This web method can be use to send an invoice priorly generated to you customer. There are many ways of using this web method for example a way to retry a failed payment using a different method this time. A scheduled recurrent invoice generation which is sent to your customer automatically after been generated by some other background process of yours. The method expect to reference your invoice by the paytoken generated by slydepay for the invoice. What happens when the invoice is sent? if it's anything aside mobible money, then a mail with an invoice like shown below is sent to your customer. When your customer clicks on prefrered channel of payment and the transaction is completed Slydepay will call your callback url and it falls under same flow you are used to where you process and call slydepay to either confirm or cancel. If the prefrered option of your 

```php
	Slydepay::sendInvoice()
		->payoption('mm') // A valid pay option.
	    ->payToken(123) // Paytoken returned by Slydepay. This is optional if orderCode is used
		->customerName('Victor') // The name of the customer.
		->customerEmail('iamovac@gmail.com') // The customer's email address.
		->from(12345) // The Phone number that will recieve this bill. 
        // ->injectConfig($this->config)
        ->run();
```

Required:
 - payToken
 - payOption
 - customerName
 - customerEmail
 - customerMobileNumber (from)

Optional:
 - externalAccountRef

[![Invoice sample](https://s3.amazonaws.com/slydepay-public/restapi/images/slydepayinvoice.png)]()
### Check payment status

Most of the time before processing what payment is made for, you will need to check the status of the payment whether successful callback or not from slydepay. This method is for that and by checking the status you have the opportunity to tell slydepay to confirm payment if status is CONFIRMED. Below are couples the list of statuses Slydepay uses.

```php
	Slydepay::checkPaymentStatus()
	    ->confirmTransaction(true) // If set to true slydepay will confirm pending payment for this order
	    ->payToken(123) // Paytoken returned by Slydepay. This is optional if orderCode is used
	    // ->injectConfig($config)
	    ->run();
```

Required:
 - confirmTransaction

Optional:
 - orderCode
 - payToken


Status | Description
-------| ----------
NEW | When there is a an order but no transaction. Happens when in integration mode or customer abandoned payment

PENDING | When the order is payed for but you have not confirmed it

CONFIRMED | When the payment is confirmed

DISPUTED | When you or Slydepay cancelled the payment

CANCELLED | When your customer raised a dispute on this payment

### Confirm transaction

Method to confirm the transaction. Assuming we received payment on your behalf and you are to process what your customer just paid for, after a successfull processing from your side , you need to call this method to confirm the payment so fund collected on your behalf is readily made available on your slydepay account. Failing to call this method, the transaction status will remain in pending mode.

```php
	SlydePay::confirmTransaction()
	    ->payToken(123) // Your merchant order unique Id generated by/in your system. This is optional if payToken or transaction id is used
	    // ->injectConfig($this->config)
	    ->run();
```

Any of this can be used in place of payToken: 
 - orderCode
 - transactionId

### Cancel transaction
Method to cancel the transaction. Assuming we received payment on your behalf and you are to process what your customer just paid for, and some issue came up with your processing and you are not able to honor the service anymore, you need to call this method to confirm the payment so fund collected on your behalf is refunded to your customer. Failing to call this method, the transaction status will remain in pending mode.

```php
	SlydePay::cancelTransaction()
	    ->payToken(123) // Your merchant order unique Id generated by/in your system. This is optional if payToken or transaction id is used
	    // ->injectConfig($this->config)
	    ->run();
```

Any of this can be used in place of paytoken: 
 - orderCode
 - transactionId

## Quality

To run the unit tests at the command line, issue `composer install` and then `phpunit` at the package root. This requires [Composer](http://getcomposer.org/) to be available as `composer`, and [PHPUnit](http://phpunit.de/manual/) to be available as `phpunit`.

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If you notice compliance oversights, please send a patch via pull request.

## Contributing

Found a bug or have a feature request? [Please have a look at the known issues](https://github.com/qodehub/slydepay/issues) first and open a new issue if necessary. Please see [contributing](CONTRIBUTING.md) and [conduct](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email victorariama@qodehub.com instead of using the issue tracker.

[clear-architecture-image]: https://img.shields.io/badge/Clear%20Architecture-%E2%9C%94-brightgreen.svg
[clear-architecture-url]: https://github.com/jkphl/clear-architecture
[author-url]: http://www.qodehub.com
[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

