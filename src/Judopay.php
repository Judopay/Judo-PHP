<?php

use Pimple\Container;

class Judopay
{
	const VERSION = '4.0.0';

	protected $container;

	public function __construct($settings = null)
	{
		// Create new DI container
		$this->container = new Container();

		// Create config object
		$this->container['configuration'] = function ($c) use ($settings) {
		    return new \Judopay\Configuration($settings);
		};

		// Create request factory
		$this->container['request'] = $this->container->factory(function ($c) {
		    $configuration = $this->get('configuration');
		    $request = new \Judopay\Request($configuration);
		    $request->setClient(new \Judopay\Client);
		    $request->setLogger($configuration->get('logger'));
		    return $request;
		});
	}

	public function get($objName)
	{
		return $this->container[$objName];
	}

	public function getModel($modelName)
	{
		$this->container[$modelName] = function ($c) use ($modelName) {
			$configuration = $this->get('configuration');

			$modelClassName = '\Judopay\Model\\'.ucfirst($modelName);
		    $model = new $modelClassName(
		    	$this->get('request')
		    );

			return $model;
		};

		return $this->get($modelName);
	}
}