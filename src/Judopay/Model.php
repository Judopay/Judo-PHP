<?php

namespace Judopay;
use \Judopay\DataType;

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

	public function create($data)
	{
		$this->checkApiMethodIsSupported(__FUNCTION__);
		return $this->request->post($this->resourcePath, $data)->json();
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
}
