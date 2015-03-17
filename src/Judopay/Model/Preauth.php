<?php

namespace Judopay\Model;

use \Judopay\DataType;

class Preauth extends \Judopay\Model\CardPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('all','create');
}
