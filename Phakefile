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
    	print_r($transaction->all());
    });
});

task('default', 'list');