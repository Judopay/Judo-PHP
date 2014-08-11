<?php

namespace Judopay\Model;
use \Judopay\DataType;

class CardPayment extends \Judopay\Model
{
	protected $resourcePath = 'transactions/payments';
	protected $validApiMethods = array('create', 'validate');
	protected $attributes = array(
		'yourConsumerReference' => DataType::TYPE_STRING,
		'yourPaymentReference' => DataType::TYPE_STRING,
		'yourPaymentMetaData' => DataType::TYPE_ARRAY,
		'judoId' => DataType::TYPE_STRING,
		'amount' => DataType::TYPE_FLOAT,
		'cardNumber' => DataType::TYPE_STRING,
		'expiryDate' => DataType::TYPE_STRING,
		'cv2' => DataType::TYPE_STRING,
		'cardAddress' => DataType::TYPE_ARRAY,
		'consumerLocation' => DataType::TYPE_ARRAY,
		'mobileNumber' => DataType::TYPE_STRING,
		'emailAddress' => DataType::TYPE_STRING
	);
	protected $requiredAttributes = array(
    	'yourConsumerReference',
    	'yourPaymentReference',
    	'judoId',
    	'amount',
    	'cardNumber',
    	'expiryDate'
    );

	/**
	 * Validate card payment details without making a payment
	 *
	 * @return array $response
	 **/
	public function validate()
	{
		$validateResourcePath = $this->resourcePath.'/validate';
		$this->checkApiMethodIsSupported(__FUNCTION__);
		$this->checkRequiredAttributes($this->attributeValues);
		return $this->request->post($validateResourcePath, json_encode($this->attributeValues))->json();
	}
}
