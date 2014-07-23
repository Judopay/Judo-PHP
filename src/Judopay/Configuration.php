<?php

namespace Judopay;

class Configuration
{
	protected $settings = array();

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

	public function __construct($settings = null)
	{
		// Set sensible defaults
		$this->settings['api_version'] = '4.0.0';

		// Override defaults with user settings
		$this->settings = array_merge($this->settings, $this->removeInvalidConfigKeys($settings));
		$this->setEndpointUrl();
	}

    public function isValidConfigKey($key)
    {
    	return (in_array($key, $this->valid_config_keys));
    }

    public function get($key)
    {
    	if (!array_key_exists($key, $this->settings)) {
    		return null;
    	}

    	return $this->settings[$key];
    }

    public function getAll()
    {
    	return $this->settings;
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

    protected function setEndpointUrl()
    {
    	if (isset($this->settings['use_production']) && $this->settings['use_production'] === true) {
    		$this->settings['endpoint_url'] = 'https://partnerapi.judopay.com';
    	} else {
    		$this->settings['endpoint_url'] = 'https://partnerapi.judopay-sandbox.com';
    	}
    }
}