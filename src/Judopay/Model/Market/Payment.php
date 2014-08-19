<?php

namespace Judopay\Model\Market;

class Payment extends \Judopay\Model
{
    protected $resourcePath = 'market/transactions/payments';
    protected $validApiMethods = array('all');
}
