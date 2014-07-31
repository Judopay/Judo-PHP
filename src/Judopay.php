<?php

use Pimple\Container;

class Judopay
{
	protected $container;

	public function __construct($settings = null)
	{
		// Create new DI container
		$this->container = new Container();

		// Create config object
		$this->container['configuration'] = function ($c) use ($settings) {
		    return new \Judopay\Configuration($settings);
		};
	}

	public function get($objName)
	{
		return $this->container[$objName];
	}

	public function getModel($modelName)
	{
		$this->container[$modelName] = function ($c) use ($modelName) {
			$modelClassName = '\Judopay\Model\\'.ucfirst($modelName);
		    $model = new $modelClassName($this->get('configuration'));
		    $model->setClient(new \Judopay\Client);
			return $model;
		};

		return $this->get($modelName);
	}
}