<?php

namespace Judopay\Model;

use Judopay\Model;

class GetTransaction extends Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('all', 'find');
}
