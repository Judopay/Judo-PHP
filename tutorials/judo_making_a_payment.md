# Making a payment - PHP

First, configure a Judopay object with your authentication credentials (as described in the Getting Started guide).

	$judopay = new \Judopay(
		array(
	        'apiToken' => 'your-token,
	        'apiSecret' => 'your-secret',
	        'judoId' => 'your-judo-id
		)
	);

To make a new payment with full card details:

	$payment = $judopay->getModel('Payment');
	$payment->setAttributeValues(
	    array(
	        'judoId' => getenv('JUDO_ID'),
	        'yourConsumerReference' => '12345',
	        'yourPaymentReference' => '12345',
	        'amount' => 1.01,
			'currency' => 'GBP',
	        'cardNumber' => '4976000000003436',
	        'expiryDate' => '12/15',
	        'cv2' => 452
	    )
	);

You can check on the required fields and the format of each field in the _Judopay REST API reference_.

To send the request to the API, call:

	$response = $payment->create();

If the payment is successful, you'll receive a response array like this:

	Array
	(
	    [receiptId] => 520882
	    [type] => Payment
	    [createdAt] => 2014-08-18T16:28:39.6164+01:00
	    [result] => Success
	    [message] => AuthCode: 476590
	    [judoId] => 100978394
	    [merchantName] => Joe Bloggs
	    [appearsOnStatementAs] => JudoPay/JoeBlo
	    [originalAmount] => 1.01
	    [netAmount] => 1.01
	    [amount] => 1.01
	    [currency] => GBP
	    [cardDetails] => Array
	        (
	            [cardLastfour] => 3436
	            [endDate] => 1215
	            [cardToken] => mw51OLKsXxm0J49qb5uVj6KJGNOgledk
	            [cardType] => 1
	        )
	
	    [consumer] => Array
	        (
	            [consumerToken] => n1uLVW6OirKhR693
	            [yourConsumerReference] => 12345
	        )
	
	    [yourPaymentReference] => 12345
	)

## Error handling

When making a payment, there are two different scenarios that can arise. 
1) ValidationError can happen when you haven’t filled in all required fields in the model.
2) ApiException can happen if you request is sent to the partner’s API and returns unsuccessful response. See [API error messages](https://www.judopay.com/docs/v5/api-reference/api-error-messages/).
It is important to handle all of the different exceptions in your code.

```php
	try {
		$response = $payment->create();
	} catch (\Judopay\Exception\ValidationError $e) {
		// There were missing or invalid fields
		echo $e->getSummary();
		print_r($e->getModelErrors()); // Array of model errors
	} catch (\Judopay\Exception\ApiException $e) {
	    // Judo API exception
		echo $e->getSummary();
		print_r($e->getFieldErrors()); // Array of field errors if they are
	} catch (\Exception $e) {
	    // A problem occurred outside the Judopay SDK
	}
```
## Logging

To help you debug your Judopay integration, you can attach a logger to the SDK. You can use any library that is compatible with the PSR-3 logging standard:

https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md

We recommend using Monolog for logging:

https://github.com/Seldaek/monolog

For example, to log debug messages to the file 'judopay.log' using Monolog:

```php
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	
	$logger = new Logger('Judopay');
	$logger->pushHandler(new StreamHandler('judopay.log'));
	$judopay = new \Judopay(
		array(
	        'apiToken' => 'your-token,
	        'apiSecret' => 'your-secret',
	        'judoId' => 'your-judo-id,
					'logger' => $logger
		)
	);
```