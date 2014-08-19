<?php

namespace Judopay\Model\WebPayments;

class Transaction extends \Judopay\Model
{
    protected $resourcePath = 'webpayments';
    protected $validApiMethods = array('find');

    /**
     * Find a specific web payment given a valid payment reference
     *
     * @param string Payment reference
     * @return array API response
     **/
    public function find($reference)
    {
        return $this->request->get($this->resourcePath.'/'.$reference)->json();
    }
}
