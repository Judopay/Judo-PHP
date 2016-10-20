<?php

namespace Judopay\Model;

use Judopay\Model;

class Transaction extends Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('all', 'find');
}
