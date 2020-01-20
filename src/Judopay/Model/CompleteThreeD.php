<?php
namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CompleteThreeD extends Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('create', 'update');

    protected $attributes
        = array(
            'ReceiptId'     => DataType::TYPE_STRING,
            'MD'            => DataType::TYPE_STRING,
            'PaRes'         => DataType::TYPE_STRING
        );

    protected $requiredAttributes
        = array(
            'ReceiptId',
            'MD',
            'PaRes'
        );

    public function complete3DSecure()
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);
        $this->checkJudoId();
        $this->checkRequiredAttributes($this->attributeValues);
        $this->resourcePath .= '/' . $this->attributeValues['ReceiptId'];
        $response = $this->request->put(
            $this->resourcePath,
            $this->attributeValues
        );
        return $this->getResponseArray($response);
    }
}
