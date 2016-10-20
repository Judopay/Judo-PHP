<?php

namespace Judopay;

use Judopay\Exception\ValidationError;
use Psr\Log\NullLogger;

class Configuration
{
    const ENDPOINT_URL = 'endpointUrl';
    const USE_PRODUCTION = 'useProduction';
    protected $settings = array();
    protected $valid_config_keys
        = array(
            'apiVersion',
            'apiToken',
            'apiSecret',
            'oauthAccessToken',
            'format',
            self::ENDPOINT_URL,
            'userAgent',
            'judoId',
            self::USE_PRODUCTION,
            'logger',
            'httpLogFormat',
        );

    public function __construct($settings = null)
    {
        // Set sensible defaults
        $this->settings['apiVersion'] = \Judopay::API_VERSION;
        $this->settings['logger'] = new NullLogger();
        $this->settings['userAgent'] = 'Judopay PHP v'.phpversion().' SDK v'.\Judopay::SDK_VERSION;
        $this->settings['httpLogFormat'] = "\"{method} {resource} {protocol}/{version}\" ".
            "{code} Content-Length: {res_header_Content-Length}\n| Response: {response}";

        // Override defaults with user settings
        $newSettings = $this->removeInvalidConfigKeys($settings);
        if (is_array($newSettings)) {
            $this->settings = array_replace($this->settings, $newSettings);
        }

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

    public function add($key, $value)
    {
        $this->settings[$key] = $value;

        return $this->settings[$key];
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
        if (isset($this->settings[static::ENDPOINT_URL])) {
            //allow custom endpoint
            return;
        } else {
            $this->settings[static::ENDPOINT_URL] = isset($this->settings[static::USE_PRODUCTION])
            && $this->settings[static::USE_PRODUCTION] === true
                ? 'https://gw1.judopay.com'
                : 'https://gw1.judopay-sandbox.com';
        }
    }

    public function validate()
    {
        $judoId = $this->get('judoId');
        $apiToken = $this->get('apiToken');
        $apiSecret = $this->get('apiSecret');
        $oauthAccessToken = $this->get('oauthAccessToken');

        if ((empty($judoId) || empty($apiToken) || empty($apiSecret)) && empty($oauthAccessToken)) {
            throw new ValidationError('SDK configuration variables missing');
        }

        $apiVersion = $this->get('apiVersion');

        if (version_compare($apiVersion, '5.0.0') < 0) {
            throw new ValidationError('Partner API under v5.0.0 is abandoned');
        }

        return true;
    }
}
