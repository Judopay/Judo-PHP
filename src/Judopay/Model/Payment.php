<?php

namespace Judopay\Model;

class Payment extends \Judopay\Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('all');
}
