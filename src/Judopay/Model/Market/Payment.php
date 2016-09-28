<?php

namespace Judopay\Model\Market;

use Judopay\Model;

class Payment extends Model
{
    protected $resourcePath = 'market/transactions/payments';
    protected $validApiMethods = array('all');
}
