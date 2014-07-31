<?php

namespace Judopay;

class Model
{
	protected $client;
	protected $configuration;
	protected $resourcePath;
	protected $validApiMethods;
	protected $attributes = array();
	protected $attributeValues = array();

	const DATA_TYPE_STRING = 'string';
	const DATA_TYPE_FLOAT = 'float';
	const DATA_TYPE_INTEGER = 'int';
	const DATA_TYPE_ARRAY = 'array';

	public function __construct(\Judopay\Configuration $configuration)
	{
		$this->configuration = $configuration;
	}

	public function setClient(\Guzzle\Http\Client $client)
	{
		$this->client = $client;
	}

	/**
	 * Retrieve a list of records
	 *
	 * @param int $offset The start point in the sorted list of records from which the results set will start
	 * @param int $pageSize The number of records to display per page
	 * @param string $sort Determines how judo sorts the list. The list can be displayed as time-descending and time-ascending.
	 * @return array
	 **/
	public function all($offset = 0, $pageSize = 10, $sort = 'time-descending')
	{
        $request = new \Judopay\Request($this->configuration);
        $request->setClient($this->client);
        $pagingOptions = array(
        	'offset' => $offset,
        	'pageSize' => $pageSize,
        	'sort' => $sort
        );
        $uri = $this->resourcePath.'?'.http_build_query($pagingOptions);
        return $request->get($uri)->json();
	}

	public function find($resourceId)
	{
        $request = new \Judopay\Request($this->configuration);
        $request->setClient($this->client);
        return $request->get($this->resourcePath.'/'.(int)$resourceId)->json();
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
			$this->attributeValues[$key] = $this->coerceAttributeValue($key, $value);
		}
	}

	protected function coerceAttributeValue($key, $value)
	{
		$targetDataType = $this->attributes[$key];

		switch ($targetDataType) {
			case self::DATA_TYPE_FLOAT:
				// Check that the provided value appears numeric
				if (!is_numeric($value)) {
					throw new \OutOfBoundsException('Invalid float value');
				}
				return (float)$value;

			case self::DATA_TYPE_ARRAY:
				if (!is_array($value)) {
					$value = array($value);
				}
				return $value;

			case self::DATA_TYPE_INTEGER:
				return (int)$value;
		}

		return $value;
	}
}
