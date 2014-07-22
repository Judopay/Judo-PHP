<?php

namespace Judopay\Models;

class Transaction extends \Judopay\Model
{
	protected $resourcePath = 'transaction';
	protected $validApiMethods = array('all');
}