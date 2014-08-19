<?php

namespace Judopay\Model\Market;

class Refund extends \Judopay\Model\Refund
{
    protected $resourcePath = 'market/transactions/refunds';
    protected $validApiMethods = array('all', 'create');
}
