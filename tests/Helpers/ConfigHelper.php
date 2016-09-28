<?php

namespace Tests\Helpers;

use Judopay\Configuration;

class ConfigHelper
{
    public static function getConfig(array $settings = array())
    {
        return new Configuration(
            $settings +
            array(
                'apiToken'      => getenv('JUDO_API_TOKEN'),
                'apiSecret'     => getenv('JUDO_API_SECRET'),
                'judoId'        => getenv('JUDO_API_ID'),
                'useProduction' => false,
            )
        );
    }

    /**
     * Returns Configuration from settings array
     * @param array $settings [judoId, apiToken, apiSecret]
     * @return Configuration
     */
    public static function getConfigFromList(array $settings)
    {
        return new Configuration(
            array(
                'judoId'        => $settings[0],
                'apiToken'      => $settings[1],
                'apiSecret'     => $settings[2],
                'useProduction' => false,
            )
        );
    }
}
