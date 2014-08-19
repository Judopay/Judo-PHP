<?php

namespace Judopay\Model;

// Extend Refund - attributes are the same
class Collection extends Refund
{
    protected $resourcePath = 'transactions/collections';
}
