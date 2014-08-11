<?php

namespace Judopay;
use \Judopay\DataType;
use \Judopay\Exception\ValidationError;

class Model
{
	protected $request;
	protected $resourcePath;
	protected $validApiMethods;
	protected $attributes = array();
	protected $attributeValues = array();
	protected $requiredAttributes = array();

	public function __construct(\Judopay\Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Retrieve a list of records
	 *
	 * @param int $offset The start point in the sorted list of records from which the results set will start
	 * @param int $pageSize The number of records to display per page
	 * @param string $sort Determines how the list is sorted. The list can be displayed as time-descending and time-ascending.
	 * @return array
	 **/
	public function all($offset = 0, $pageSize = 10, $sort = 'time-descending')
	{
		$this->checkApiMethodIsSupported(__FUNCTION__);
        $pagingOptions = array(
        	'offset' => $offset,
        	'pageSize' => $pageSize,
        	'sort' => $sort
        );
        $uri = $this->resourcePath.'?'.http_build_query($pagingOptions);
        return $this->request->get($uri)->json();
	}

	public function find($resourceId)
	{
		$this->checkApiMethodIsSupported(__FUNCTION__);
        return $this->request->get($this->resourcePath.'/'.(int)$resourceId)->json();
	}

	public function create()
	{
		$this->checkApiMethodIsSupported(__FUNCTION__);
		$this->checkJudoId();
		$this->checkRequiredAttributes($this->attributeValues);

		return $this->request->post($this->resourcePath, json_encode($this->attributeValues))->json();
	}

	public function getAttributeValue($attribute)
	{
		if (!array_key_exists($attribute, $this->attributeValues)) {
			return null;
		}

		return $this->attributeValues[$attribute];
	}

	public function getAttributeValues()
	{
		return $this->attributeValues;
	}

	public function setAttributeValues($values)
	{
		foreach ($values as $key => $value) {
			// Does the attribute exist?
			if (!array_key_exists($key, $this->attributes)) {
				continue;
			}

			// Coerce to the right type if required
			$targetDataType = $this->attributes[$key];
			$this->attributeValues[$key] = \Judopay\DataType::coerce($targetDataType, $value);
		}
	}

	protected function checkApiMethodIsSupported($methodName)
	{
		if (empty($this->validApiMethods) || !in_array($methodName, $this->validApiMethods)) {
			throw new \RuntimeException('API method is not supported');
		}
	}

	/**
	 * Check if request data contains all of the required attributes to create a new record
	 *
	 * @param array $data Request data
	 **/
	protected function checkRequiredAttributes($data)
	{
		$existingAttributes = array_keys($data);
		$errors = array();
		foreach ($this->requiredAttributes as $requiredAttribute) {
			if (!in_array($requiredAttribute, $existingAttributes)) {
				$errors[] = $requiredAttribute.' is missing';
			}
		}

		if (count($errors) > 0) {
			throw new \Judopay\Exception\ValidationError('Missing required fields', $errors);
		}

		return true;
	}

	/**
	 * If a Judo ID is not set, use the value from configuration
	 **/
	protected function checkJudoId()
	{
		$judoId = $this->getAttributeValue('judoId');
		if (!empty($judoId)) {
			return;
		}

		$configuration = $this->request->getConfiguration();
		$this->attributeValues['judoId'] = '123-456'; //$configuration->get('judoId');
	}
}
