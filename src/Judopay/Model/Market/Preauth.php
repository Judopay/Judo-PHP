<?php

namespace Judopay\Model\Market;

use Judopay\Model;

class Preauth extends Model
{
    protected $resourcePath = 'market/transactions/preauths';
    protected $validApiMethods = array('all');
}
