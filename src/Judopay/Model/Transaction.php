<?php

namespace Judopay\Model;
use \Judopay\DataType;

class Transaction extends \Judopay\Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('all', 'find');
}