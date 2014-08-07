<?php

namespace Judopay\Test;

/**
 * Build model objects with standard test data
 * to reduce duplication in tests
 **/
abstract class AbstractModelBuilder
{
	/**
	 * Array of attributes (key => value)
	 *
	 * @var array
	 **/
	protected $attributeValues;

	/**
	 * Create a new model object with attributes set
	 *
	 * @return object Model object
	 **/
	public function build()
	{
		$modelName = '\Judopay\Model\\'.substr(get_class($this, 0, -7));
		$model = new $modelName(new \Judopay\Request);
		$model->setAttributeValues($this->attributeValues);
		return $model;
	}

	/**
	 * Retrieve an array of test data attributes
	 * Can be used directly in a setAttributeValues() method call
	 *
	 * @return array Array of attribute values (key => value)
	 **/
	public function getAttributeValues()
	{
		return $this->attributeValues;
	}
}