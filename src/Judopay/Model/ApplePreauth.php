<?php

namespace Judopay\Model;

class ApplePreauth extends ApplePayment
{
    protected $resourcePath = 'transactions/preauths';
}
