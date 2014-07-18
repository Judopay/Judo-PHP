<?php

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

task('list', function() {
    passthru("./bin/phake -T");
});

desc('Generate phpDocumentor docs');
task('doc', function() {
    passthru("./bin/phpdoc -d ./src -t ./doc");
});

desc('Run phpspec tests');
task('test', function() {
    passthru("./bin/phpspec run");
});

task('default', 'list');