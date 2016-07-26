<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Judopay\Helper;

/**
 * Class ArrayHelper
 * @package Judopay\Helper
 */
class ArrayHelper
{
    /**
     * Returns value from array by index or default
     * @param array $array
     * @param mixed $index
     * @param mixed $default
     * @return mixed array value or default
     */
    public static function get(array $array, $index, $default = null)
    {
        return isset($array[$index])
            ? $array[$index]
            : $default;
    }
}
