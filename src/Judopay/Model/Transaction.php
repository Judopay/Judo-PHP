<?php

namespace Judopay\Model;

class Transaction extends \Judopay\Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('all', 'find');
}
