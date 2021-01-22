<?php

namespace Judopay\Model;

class OneUseTokenPreauth extends OneUseTokenPayment
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('create');
}
