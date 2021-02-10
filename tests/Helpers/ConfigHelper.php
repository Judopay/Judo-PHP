<?php

namespace Tests\Helpers;

use Judopay\Configuration;

class ConfigHelper
{
    /**
     * Returns Configuration from the environment variables
     * @param array $settings custom settings
     * @return Configuration
     */
    public static function getBaseConfig(array $settings = array())
    {
        return new Configuration(
            $settings +
            array(
                'judoId'        => getenv('BASE_JUDOID'),
                'apiToken'      => getenv('BASE_TOKEN'),
                'apiSecret'     => getenv('BASE_SECRET'),
                'useProduction' => false,
            )
        );
    }

    /**
     * Returns Configuration from an alternate set of environment variables that allow CheckCard operations
     * @param array $settings custom settings
     * @return Configuration
     */
    public static function getCybersourceConfig(array $settings = array())
    {
        return new Configuration(
            $settings +
            array(
                'judoId'        => getenv('CYB_JUDOID'),
                'apiToken'      => getenv('CYB_TOKEN'),
                'apiSecret'     => getenv('CYB_SECRET'),
                'useProduction' => false,
            )
        );
    }

    /**
     * Returns Configuration from an alternate set of environment variables that allow 3DS2 operations
     * @param array $settings custom settings
     * @return Configuration
     */
    public static function getSafeChargeConfig(array $settings = array())
    {
        return new Configuration(
            $settings +
            array(
                'judoId'        => getenv('SC_JUDOID'),
                'apiToken'      => getenv('SC_TOKEN'),
                'apiSecret'     => getenv('SC_SECRET'),
                'useProduction' => false,
            )
        );
    }

    /**
     * Returns Configuration from settings array
     * @param array $credentials [judoId, apiToken, apiSecret]
     * @param array $settings custom settings
     * @return Configuration
     */
    public static function getConfigFromList(array $credentials, array $settings = array())
    {
        return new Configuration(
            array(
                'judoId'        => $credentials[0],
                'apiToken'      => $credentials[1],
                'apiSecret'     => $credentials[2],
                'useProduction' => false,
            ) + $settings
        );
    }
}
