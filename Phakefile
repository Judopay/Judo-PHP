<?php

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

task('list', function() {
    passthru("./bin/phake -T");
});

desc('Generate phpDocumentor docs');
task('doc', function() {
    passthru("phpdoc -d ./src -t ./doc");

    // Fix missing font in generated docs
    // https://github.com/phpDocumentor/template.clean/pull/41
    passthru('cp -fR font doc/');
});

desc('Generate phpDocumentor docs in XML format');
task('doc_xml', function() {
    passthru('phpdoc -d ./src -t ./doc  --template="xml"');
});

desc('Run phpspec tests');
task('test', function() {
    passthru("./bin/phpspec run");
});

group('transactions', function() {
    task('all', function() {

        // Create logger
        $logger = new Logger('Judopay');
        $logger->pushHandler(new StreamHandler('judopay.log'));

    	$judopay = new \Judopay(
    		array(
                'apiToken' => getenv('JUDO_TOKEN'),
                'apiSecret' => getenv('JUDO_SECRET'),
                'judoId' => getenv('JUDO_ID'),
                'logger' => $logger
    		)
    	);

    	$transaction = $judopay->getModel('Transaction');
    	print_r($transaction->all());
    });

    task('find', function() {
        $judopay = new \Judopay(
            array(
                'apiToken' => getenv('JUDO_TOKEN'),
                'apiSecret' => getenv('JUDO_SECRET'),
                'judoId' => getenv('JUDO_ID')
            )
        );

        $transaction = $judopay->getModel('Transaction');
        print_r($transaction->find(497107));
    });

    task('create', function() {
        // Create logger
        $logger = new Logger('Judopay');
        $logger->pushHandler(new StreamHandler('judopay.log'));

        $judopay = new \Judopay(
            array(
                'apiToken' => getenv('JUDO_TOKEN'),
                'apiSecret' => getenv('JUDO_SECRET'),
                'judoId' => getenv('JUDO_ID'),
                'logger' => $logger
            )
        );

        $transaction = $judopay->getModel('CardPayment');
        $transaction->setAttributeValues(
            array(
                'judoId' => getenv('JUDO_ID'),
                'yourConsumerReference' => '12345',
                'yourPaymentReference' => '12345',
                'amount' => 1.01,
                'cardNumber' => '4976000000003436',
                'expiryDate' => '12/15',
                'cv2' => 452
            )
        );
        $result = $transaction->create();

        print_r($result);
    });

});

group('web_payments', function() {
    task('create', function() {
        // Create logger
        $logger = new Logger('Judopay');
        $logger->pushHandler(new StreamHandler('judopay.log'));

        $judopay = new \Judopay(
            array(
                'apiToken' => getenv('JUDO_TOKEN'),
                'apiSecret' => getenv('JUDO_SECRET'),
                'judoId' => getenv('JUDO_ID'),
                'logger' => $logger
            )
        );

        $transaction = $judopay->getModel('WebPayments\Payment');
        $transaction->setAttributeValues(
            array(
                'judoId' => getenv('JUDO_ID'),
                'yourConsumerReference' => '12345',
                'yourPaymentReference' => '12345',
                'amount' => 1.01,
            )
        );
        
        try {
            $result = $transaction->create();
        } catch (\Judopay\Exception\ValidationError $e) {
            // There were missing or invalid fields
            echo $e->getSummary();
            print_r($e->getModelErrors()); // Array of model errors
        } catch (\Judopay\Exception\BadRequest $e) {
          // Invalid parameters were supplied to Judopay's API
            echo $e->getSummary();
            print_r($e->getModelErrors()); // Array of model errors
        } catch (\Judopay\Exception\    NotAuthorized $e) {
            // You're not authorized to make the request - check credentials and permissions in the Judopay portal
        } catch (\Judopay\Exception\NotFound $e) {
            // The resource was not found
        } catch (\Judopay\Exception\Conflict $e) {
            // Rate limiting - you have made too many requests to the Judopay API
        } catch (\Exception $e) {
          // A problem occurred outside the Judopay SDK
        }        

        print_r($result);
    });

    task('find', function() {
        $judopay = new \Judopay(
            array(
                'apiToken' => getenv('JUDO_TOKEN'),
                'apiSecret' => getenv('JUDO_SECRET'),
                'judoId' => getenv('JUDO_ID')
            )
        );

        $transaction = $judopay->getModel('WebPayments\Transaction');
        print_r($transaction->find('3gcAAAgAAAAMAAAACwAAANCEpjI078FA-82yABvtFm2etJbVenSv3oIfp75Y2t1KVXfysg'));
    });     
});
task('default', 'list');