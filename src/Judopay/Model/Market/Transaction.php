<?php

namespace Judopay\Model\Market;

class Transaction extends \Judopay\Model
{
    protected $resourcePath = 'market/transactions';
    protected $validApiMethods = array('all');
}