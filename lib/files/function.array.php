<?php

declare(strict_types=1);

if( ! function_exists('array_get'))
{

    /**
     * Gibt anhand eines Schlüssels $key den Inhalt eines Arrays $array wieder.
     * Optional kann ein Wert $default angegeben werden, der bei nicht vorhandenen Schlüssel als
     * Ergebnis geliefert wird.
     *
     * @param	array	$array
     * @param	string	$key
     * @param	mixed	$default	[optional]
     * @return	mixed
     **/
    function array_get(array $array, string $key, mixed $default = null): mixed
    {

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment)
        {

            if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
                return value($default);
            }

            $array = $array[$segment];

        }

        return $array;

    }

}
