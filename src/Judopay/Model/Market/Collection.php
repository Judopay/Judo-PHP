<?php

namespace Judopay\Model\Market;

class Collection extends \Judopay\Model\Collection
{
    protected $resourcePath = 'market/transactions/collections';
    protected $validApiMethods = array('all', 'create');
}
