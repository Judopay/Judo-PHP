<?php

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

task('list', function() {
    passthru("./bin/phake -T");
});

task('default', 'list');