#!/bin/bash
set -e #exit on any error
./bin/phpspec run #Run PHPSpec
./bin/phpcs --standard=.phpcs.xml src #Run CodeSniffer