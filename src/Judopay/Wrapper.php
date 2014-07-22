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

    public function transaction()
    {
        return new \Judopay\Models\Transaction($configuration);
    }
}
