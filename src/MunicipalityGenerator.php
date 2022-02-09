<?php

namespace BrandonLeeDetty\PhpCacheObjects;

class MunicipalityGenerator
{
    private static $id = 0;

    public static function getArray()
    {
        ++static::$id;

        return [
            'id' => static::$id,
            'name' => 'Name',
            'type' =>  'City',
        ];
    }

    public static function getObject()
    {
        ++static::$id;

        $city = new Municipality();
        $city->id = static::$id;
        $city->name = 'Name';
        $city->type = 'City';

        return $city;
    }
}
