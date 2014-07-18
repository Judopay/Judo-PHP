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

    // Fix missing font in generated docs
    // https://github.com/phpDocumentor/template.clean/pull/41
    passthru('cp -fR font doc/');
});

desc('Run phpspec tests');
task('test', function() {
    passthru("./bin/phpspec run");
});

task('default', 'list');