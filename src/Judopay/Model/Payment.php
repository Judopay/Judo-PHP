<?php

namespace Judopay\Model;

class Payment extends CardPayment
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = ['all', 'create', 'validate'];
}
