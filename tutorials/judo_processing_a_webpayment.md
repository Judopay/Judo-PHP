# Making a WebPayment - PHP

JudoResponsive allows you to easily accept card payments within your WebApp. judoResponsive supports both desktop and mobile devices, eases your PCI-DSS compliance, and includes additional card holder verification using Post-code verification and 3D secure. 

Before proceeding you should review the Getting Started guide to set up your PHP application environment including; creating and configuring your app on our [merchant dashboard](https://portal.judopay.com), retrieving your API token and secret, installing the JudoPay Composer package etc.

## Configuration

Before you can process web payments, you'll need to create an application on our [merchant dashboard](https://portal.judopay.com). This application allows you to control your processing options (3D secure), as well as specifies the URLs we'll use to return your user back to your website upon completion of the payment.

### Configuration Checklist

* You need to have set up the "Success" and "Cancel" urls for your application. As you'd expect we return your user to the success url upon successful payment, and the cancel url if they abort the payment process.
* Your API token needs to have the permissions to "create" web payments, you can edit these permissions on the application configuration screen within our [merchant dashboard](https://portal.judopay.com)


## Provisioning the web payment

Before you can send your user to the judo payment page, you'll need to tell us the details of the web payment using our JudoPay API. Support for this is built into our PHP SDK:


```PHP

// Create the JudoPay client, populate the api token and api secret with the 
// details from the application you created on our 
$judopay = new \Judopay(
	array(
        'apiToken' => 'your-token',
        'apiSecret' => 'your-secret',
        'judoId' => 'your-judo-id'
	)
);

// create an instance of the WebPayment Payment model (or you can use the Preauth model) 
// if you only want to process a pre-authorisation which you can collect later.

$payment = $judopay->getModel('WebPayments\Payment');

// populate the required data fields.
$payment->setAttributeValues(
    array(
        'judoId' => getenv('JUDO_ID'),
        'yourConsumerReference' => '12345',
        'yourPaymentReference' => '12345',
        'amount' => 1.01,
        'clientIpAddress' => '127.0.0.1',
        'clientUserAgent' => 'Their browser user agent/11.0',
    )
);

// Send the model to the JudoPay API, this provisions your webpayment and returns a unique reference along with the 
// URL of the page you'll need to dispatch your users to.

$webpaymentDetails = $payment->create();

/*
* Here's an example of the json returned, this is mapped into an Array.
* {
* postUrl: https://pay.judopay-sandbox.com/v1,
* reference: "3gcAAAoAAAAXAAAACQAAAMYG6P4SW.....CCc3iT-3tn5_RyWnmArDZAwyEkwQ"
* }
*/

$theWebPaymentReference = $webpaymentDetails["reference"]
$formPostUrl = $webpaymentDetails["postUrl"]
```
## Dispatching your user to judo  

You should then dispatch your user to our server using a POST request, this can be done easily by wrapping your "Pay Now" button in a form as follows:


```HTML+PHP
<form action="<?php echo $formPostUrl;?>" method="post">
<input  id="Reference" name="Reference" type="hidden" value="<?php echo $theWebPaymentReference;?>">
<input type="submit" value="Pay now">
</form>
```

## Capturing the returned information

If the user's payment was successful we'll return them to your success url (again using a POST request), along with some additional form fields you should capture. These are:

**Reference** - this is our reference for the web payment.

**ReceiptId** - this is our reference number for the JudoPay API transaction.

**CardToken** - this is the unique reference for your user's card. If you want to process further payments on their card (either as a "saved card" feature, or a reoccuring subscription payment), you must capture this card token.

## Verifying the payment

Finally you should always verify the payment outcome using the JudoPay API, this protects you from request tampering.

```PHP

// Create an instance of the WebPayment Transaction model (as web payments can either be payments or preauths we have a superclass called transaction). 

$existingTransactionRequest = $judopay->getModel('WebPayments\Transaction');


// invoke the find method passing in the reference you obtained above. 
$transactionDetails = $existingTransactionRequest->find($theWebPaymentReference);

// check the value of the "status" array key to confirm the payment was successful
$webpaymentStatus = $transactionDetails["status"];

// webpaymentStatus should be "Paid"

// you can also access a copy of our receipt object using the "receipt" entry.

$receipt = $transactionDetails["receipt"];

```