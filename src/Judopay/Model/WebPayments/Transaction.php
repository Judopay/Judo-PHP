<?php

namespace Judopay\Model\WebPayments;

use Judopay\Model;

class Transaction extends Model
{
    protected $resourcePath = 'webpayments';
    protected $validApiMethods = array('find');

    /**
     * Find a specific web payment given a valid payment reference
     * @param string $reference Payment reference
     * @return array API response
     **/
    public function find($reference)
    {
        return $this->request->get($this->resourcePath.'/'.$reference)->json();
    }
}
