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
    	$judopay = new \Judopay(
    		array(
    			'api_token' => getenv('JUDO_TOKEN'),
    			'api_secret' => getenv('JUDO_SECRET'),
    			'judo_id' => getenv('JUDO_ID')
    		)
    	);

    	$transaction = $judopay->getModel('Transaction');
    	$transaction->setClient(new \Guzzle\Http\Client);
    	print_r($transaction->all());
    });

    task('find', function() {
        $judopay = new \Judopay(
            array(
                'api_token' => getenv('JUDO_TOKEN'),
                'api_secret' => getenv('JUDO_SECRET'),
                'judo_id' => getenv('JUDO_ID')
            )
        );

        $transaction = $judopay->getModel('Transaction');
        $transaction->setClient(new \Guzzle\Http\Client);
        print_r($transaction->find(465906));
    });
});

task('default', 'list');