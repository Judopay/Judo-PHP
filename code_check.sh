#!/bin/bash
set -e #exit on any error
./bin/phpcs --standard=.phpcs.xml src #Run CodeSniffer on src dir
./bin/phpcs --standard=.phpcs.xml spec --exclude="PSR1.Methods.CamelCapsMethodName" #Run CodeSniffer on spec without CamelCapsMethodName rule
./bin/phpcs --standard=.phpcs.xml tests #Run CodeSniffer on test
./bin/phpspec run #Run PHPSpec
./bin/phpunit #Run PHPUnit
