<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

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
}
