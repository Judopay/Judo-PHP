# Judopay PHP SDK

[![Build Status](https://travis-ci.org/JudoPay/PhpSdk.svg?branch=master)](https://travis-ci.org/JudoPay/PhpSdk)

The judopay php SDK is not actively supported by judo, but it is available here for anyone who wish to use it as a platform to develop upon.

## Installation

The Judopay PHP SDK supports PHP 5.3.3 and above. You'll need the PHP cURL extension installed.

Installation of the SDK is via the Composer package manager. Add the judopay package to your composer.json file:

    "require": {
        "judopay/judopay-sdk": "~1.0"
    }

And then execute:

    $ composer install

Make sure you require the 'vendor/autoload.php' file, so that the Judopay SDK classes are available to your application.

For more information on getting started with Composer, see:

https://getcomposer.org/doc/00-intro.md

# Configuration

To start using the SDK, create a new Judopay object with your API credentials:

	$judopay = new \Judopay(
		array(
	        'apiToken' => 'your-token,
	        'apiSecret' => 'your-secret',
	        'judoId' => 'your-judo-id'
		)
	);
