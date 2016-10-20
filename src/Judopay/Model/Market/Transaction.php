<?php

namespace Judopay\Model\Market;

use Judopay\Model;

class Transaction extends Model
{
    protected $resourcePath = 'market/transactions';
    protected $validApiMethods = array('all');
}
