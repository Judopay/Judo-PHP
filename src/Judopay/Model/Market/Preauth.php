<?php

namespace Judopay\Model\Market;

class Preauth extends \Judopay\Model
{
    protected $resourcePath = 'market/transactions/preauths';
    protected $validApiMethods = array('all');
}
