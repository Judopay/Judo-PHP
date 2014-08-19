<?php

namespace Judopay\Model\WebPayments;

class Preauth extends Payment
{
    protected $resourcePath = 'webpayments/preauths';
    protected $validApiMethods = array('create');
}
