<?php

namespace Judopay\Model;

class Preauth extends CardPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('all','create', 'validate');
}
