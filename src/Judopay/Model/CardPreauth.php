<?php

namespace Judopay\Model;

// Inherit from CardPayment - attributes are identical
class CardPreauth extends CardPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('create');
}
