#!/bin/bash
set -e #exit on any error
: ${JUDO_API_TOKEN:?"Need to set JUDO_API_TOKEN env variable"}
: ${JUDO_API_SECRET:?"Need to set JUDO_API_SECRET env variable"}
: ${JUDO_API_ID:?"Need to set JUDO_API_ID env variable"}
./bin/phpcs --standard=.phpcs.xml src #Run CodeSniffer on src dir
./bin/phpcs --standard=.phpcs.xml spec --exclude="PSR1.Methods.CamelCapsMethodName" #Run CodeSniffer on spec without CamelCapsMethodName rule
./bin/phpcs --standard=.phpcs.xml tests #Run CodeSniffer on test
./bin/phpspec run #Run PHPSpec
./bin/phpunit --stop-on-failure #Run PHPUnit
