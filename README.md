# Judopay PHP SDK [![Build Status](https://travis-ci.org/Judopay/Judo-PHP.svg?branch=master)](https://travis-ci.org/Judopay/Judo-PHP)
The JudoPay SDK provides you with ability to integrate card payments into your PHP project. Judo's SDK enables a faster, simpler and more secure payment experience within your app.
##### **\*\*\*Due to industry-wide security updates, versions below 2.0 of this SDK will no longer be supported after 1st Oct 2016. For more information regarding these updates, please read our blog [here](http://hub.judopay.com/pci31-security-updates/).*****

## Requirements
For the Judo PHP library in order to work correctly with your developer setup, please ensure the following requirements are met:

- PHP 5.3.3 and above
- PHP cURL extension
- [Composer](https://getcomposer.org/download/)

## Getting started
##### 1. Integration
Installation of the SDK is implemented via the Composer package manager. Add the judopay package to your composer.json file:
```json
    "require": {
        "judopay/judopay-sdk": "~2.0"
    }
```
And then execute:
```bash
    $ composer install
```
Make sure you require the 'vendor/autoload.php' file, so that the Judopay SDK classes are available to your application.
For more information on getting started with Composer, see [Composer intro](https://getcomposer.org/doc/00-intro.md).

##### 2. Setup
To start using the SDK, create a new Judopay object with your API credentials:
```php
    $judopay = new \Judopay(
        array(
            'apiToken' => 'your-token,
            'apiSecret' => 'your-secret',
            'judoId' => 'your-judo-id'
        )
    );
```

##### 3. Make a payment
To make a new payment with full card details:
```php
    $payment = $judopay->getModel('Payment');
    $payment->setAttributeValues(
        array(
            'judoId' => 'your_judo_id',
            'yourConsumerReference' => '12345',
            'yourPaymentReference' => '12345',
            'amount' => 1.01,
            'currency' => 'GBP',
            'cardNumber' => '4976000000003436',
            'expiryDate' => '12/15',
            'cv2' => 452
        )
    );
```
**Note:** Please make sure that you are using a unique Consumer Reference for each different consumer, and a unique Payment Reference for each transaction.

You can check on the required fields and the format of each field in the [Judopay REST API reference](https://www.judopay.com/docs/v5/api-reference/restful-api/#post-card-payment).
To send the request to the API, call:
```php
    $response = $payment->create();
```

##### 4. Check the payment result
If the payment is successful, you'll receive a response array like this (see full response [here](https://www.judopay.com/docs/v5/api-reference/restful-api/#post-card-payment)):
```php
    Array
    (
        [receiptId] => 520882
        [type] => Payment
        [createdAt] => 2014-08-18T16:28:39.6164+01:00
        [result] => Success
        ...
        [amount] => 10.00
        ...	
        [yourPaymentReference] => 12345
    )
```
Also important to handle different exceptions in your code. See more details in our [error handling section](https://github.com/JudoPay/PhpSdk/wiki/Error-handling). 
```php
    try {
        $response = $payment->create();
        if ($response['result'] === 'Success') {
            echo 'Payment succesful';
        } else {
            echo 'There were some problems while processing your payment';
        }
    } catch (\Judopay\Exception\ValidationError $e) {
        echo $e->getSummary();
    } catch (\Judopay\Exception\ApiException $e) {
        echo $e->getSummary();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
```

## Next steps
The judo PHP SDK supports a range of customization options. For more information on using judo see our [wiki documentation](https://github.com/JudoPay/PhpSdk/wiki). 

## License
See the [LICENSE](https://github.com/JudoPay/PhpSdk/blob/master/LICENSE.txt) file for license rights and limitations (MIT).
