<?php

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

    /**
     * Checks for existence of an array element key.
     * @param array  $array Array or object to check index
     * @param string $key   Key of the array element, specified in a dot format.
     *                      e.g. if the key is `x.y.z`, then the returned value would be `$array['x']['y']['z']`
     * @return bool
     */
    public static function keyExists(array $array, $key)
    {
        if (($pos = strrpos($key, '.')) !== false
            && ($subKey = substr($key, 0, $pos)) !== false
            && static::keyExists($array, $subKey)
            && static::keyExists($array[$subKey], substr($key, $pos + 1))
        ) {
            return true;
        }

        return (isset($array[$key]) || array_key_exists($key, $array));
    }
}
