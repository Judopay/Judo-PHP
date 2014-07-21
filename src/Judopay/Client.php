<?php

namespace Judopay;

class Client
{
	protected $config;
	protected $valid_config_keys = array(
    	'api_version',
        'api_token',
        'api_secret',
        'oauth_access_token',
        'format',
        'endpoint_url',
        'user_agent',
        'judo_id',
        'use_production'
	);

	public function __construct($config = null)
	{
		$this->config = $this->removeInvalidConfigKeys($config);
	}

    public function getConfig()
    {
    	return $this->config;
    }

    public function isValidConfigKey($key)
    {
    	return (in_array($key, $this->valid_config_keys));
    }

    protected function removeInvalidConfigKeys($config)
    {
    	if (!is_array($config)) {
    		return false;
		}

		$output = array();

		foreach ($config as $key => $value) {
			if (in_array($key, $this->valid_config_keys)) {
				$output[$key] = $value;
			}
		}

		return $output;
    }
}
