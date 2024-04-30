<?php

namespace App\Helpers;

class ArrayHelpers
{
    public static function removeNullsFromArray(array $array): array
    {
        return array_filter(
            array: $array,
            callback: function ($var) {
                return $var !== null;
            }
        );
    }
}
