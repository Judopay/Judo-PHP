<?php

namespace Judopay\Model;

// Inherit from TokenPayment - attributes are identical
class TokenPreauth extends TokenPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('create');
}
