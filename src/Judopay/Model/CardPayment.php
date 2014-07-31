<?php

namespace Judopay\Model;
use \Judopay\DataType;

class CardPayment extends \Judopay\Model
{
	protected $resourcePath = 'transactions/payments';
	protected $validApiMethods = array();
	protected $attributes = array(
		'yourPaymentMetaData' => DataType::TYPE_ARRAY,
		'judoId' => DataType::TYPE_STRING,
		'amount' => DataType::TYPE_FLOAT
	);
}