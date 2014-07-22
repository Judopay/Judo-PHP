<?php

namespace Judopay;

class Wrapper
{
	protected $configuration;

	public function __construct($settings = null)
	{
		$this->configuration = new \Judopay\Configuration($settings);
	}

	public function configuration()
	{
        return $this->configuration;
	}
}
