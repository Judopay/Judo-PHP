<?php

namespace Judopay\Model;
use \Judopay\DataType;

class Payment extends \Judopay\Model
{
	protected $resourcePath = 'transactions/payments';
	protected $validApiMethods = array('all');
}