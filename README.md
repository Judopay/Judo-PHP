# Judopay PHP SDK [![Build Status](https://travis-ci.org/Judopay/Judo-PHP.svg?branch=master)](https://travis-ci.org/Judopay/Judo-PHP)
The JudoPay SDK provides you with the ability to integrate card payments into your PHP project. Judo's SDK enables a faster, simpler, and more secure payment experience within your app.
##### **\*\*\*Due to industry-wide security updates, versions below 2.0 of this SDK will no longer be supported after 1st Oct 2016. For more information regarding these updates, please read our blog [here](http://hub.judopay.com/pci31-security-updates/).*****

## Requirements
In order for the Judo PHP library to work correctly with your development setup, please ensure the following requirements are met:

- PHP 5.5 and above
- [Composer](https://getcomposer.org/download/)

## Getting started
##### 1. Integration
Installation of the SDK is implemented via the Composer package manager. Add the judopay package to your composer.json file:
```json
    "require": {
        "judopay/judopay-sdk": "5.0.0"
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
    $judopay = new Judopay(
        array(
            'apiToken' => 'your-token',
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
            'expiryDate' => '12/25',
            'cv2' => 452
        )
    );
```
**Note:** Please make sure that you are using a unique Consumer Reference for each different consumer, and a unique Payment Reference for each transaction.

Card address details can optionally be included for use in AVS checks as follows, (see full list of parameters [here](https://docs.judopay.com/Content/Server%20SDKs/Server%20SDKs_1.htm#Server))

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
            'expiryDate' => '12/25',
            'cv2' => 452,
            'cardAddress' => array('address1' => '1 Market Street', 'postCode' => 'E20 6PQ', 'countryCode' => 826)
        )
    );
```

You can check on the required fields and the format of each field in the [Judopay REST API reference](https://docs.judopay.com/api-reference/index.html).
To send the request to the API, call:
```php
    $response = $payment->create();
```

##### 4. Check the payment result
If the payment is successful, you'll receive a response array like this (see full response [here](https://docs.judopay.com/Content/Server%20SDKs/Server%20SDKs_1.htm#Server)):
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
Also important to handle different exceptions in your code. See more details in our [error handling section](https://docs.judopay.com/Content/Sandbox%20Testing/Test%20Scenarios.htm).
```php
    try {
        $response = $payment->create();
        if ($response['result'] === 'Success') {
            echo 'Payment successful';
        } else {
            echo 'There were some problems while processing your payment';
        }
    } catch (JudopayExceptionValidationError $e) {
        echo $e->getSummary();
    } catch (JudopayExceptionApiException $e) {
        echo $e->getSummary();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
```

## Next steps
The Judo PHP SDK supports a range of customization options. For more information on using Judo see our [documentation](https://docs.judopay.com/Content/Server%20SDKs/Server%20SDKs_1.htm#Server). 

## License
See the [LICENSE](https://github.com/JudoPay/PhpSdk/blob/master/LICENSE.txt) file for license rights and limitations (MIT).
