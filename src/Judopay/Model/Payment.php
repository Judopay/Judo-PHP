<?php

namespace Judopay\Model;

class Payment extends \Judopay\Model\CardPayment
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('all', 'create');
}
