<?php

namespace Judopay\Models;

class Transaction extends \Judopay\Model
{
	protected $resourcePath = 'transactions';
	protected $validApiMethods = array('all');
}