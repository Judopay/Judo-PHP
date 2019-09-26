<?php

use Judopay\Configuration;
use Pimple\Container;
use Judopay\Client;
use Judopay\Request;

/**
 * Main Judopay wrapper
 * Handle initial configuration and build service objects
 * @package      Judopay
 */
class Judopay
{
    const SDK_VERSION = '4.0.0';
    const API_VERSION = '5.5.1';
    /**
     * Pimple DI container
     * @var object Pimple\Container
     **/
    protected $container;

    /**
     * @param array $settings Configuration settings (e.g. [judoId] => '123-456')
     **/
    public function __construct($settings = null)
    {
        // Create new DI container
        $this->container = new Container();

        // Create config object
        $this->container['configuration'] = function () use ($settings) {
            return new Configuration($settings);
        };

        // Create request factory
        $this->container['request'] = $this->container->factory(
            function ($c) {
                /** @var Configuration $configuration */
                $configuration = $c['configuration'];
                $request = new Request($configuration);

                // The client is now immutable and needs all the options on creation
                $client = new Client([
                    'base_uri' => $configuration->get("endpointUrl"), // Base URI is used with relative requests
                    'verify' =>  __DIR__.'/../cert/digicert_sha256_ca.pem'
                ]);

                $request->setClient($client);

                return $request;
            }
        );
    }

    /**
     * Get an object from the DI container
     * @param string Object name
     * @return object
     **/
    public function get($objName)
    {
        return $this->container[$objName];
    }

    /**
     * Build a new model object
     * @param string $modelName
     * @return object
     */
    public function getModel($modelName)
    {
        // If the model is already defined in the container, just return it
        if (isset($this->container[$modelName])) {
            return $this->get($modelName);
        }

        // Set up the model in the DI container
        $request = $this->get('request');
        $this->container[$modelName] = $this->container->factory(
            function () use ($modelName, $request) {
                $modelClassName = '\Judopay\Model\\'.ucfirst($modelName);

                return new $modelClassName($request);
            }
        );

        return $this->get($modelName);
    }
}
