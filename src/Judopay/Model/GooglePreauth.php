<?php

namespace Judopay\Model;

class GooglePreauth extends GooglePayment
{
    protected $resourcePath = 'transactions/preauths';
}
