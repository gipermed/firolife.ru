<?php


namespace Palladiumlab\Support\Util;


use Illuminate\Support\Arr as IlluminateArr;

class Arr extends IlluminateArr
{
    public static function combineKeys(array $array, string $key): array
    {
        return (array)array_combine(array_column($array, $key), array_values($array));
    }
}