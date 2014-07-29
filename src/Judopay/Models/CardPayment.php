<?php

namespace Judopay\Models;

class CardPayment extends \Judopay\Model
{
	protected $resourcePath = 'transactions/payments';
	protected $validApiMethods = array();
	protected $attributes = array(
		'yourPaymentMetaData' => self::DATA_TYPE_ARRAY,
		'judoId' => self::DATA_TYPE_STRING,
		'amount' => self::DATA_TYPE_FLOAT
	);
}