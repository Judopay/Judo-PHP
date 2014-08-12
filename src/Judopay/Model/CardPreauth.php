<?php

namespace Judopay\Model;
use \Judopay\DataType;

// Inherit from CardPayment - attributes are identical
class CardPreauth extends \Judopay\Model\CardPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('create');
}
