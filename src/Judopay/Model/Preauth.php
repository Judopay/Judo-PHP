<?php

namespace Judopay\Model;

class Preauth extends \Judopay\Model
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('all');
}
