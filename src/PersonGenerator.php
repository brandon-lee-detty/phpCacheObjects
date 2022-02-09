<?php

namespace BrandonLeeDetty\PhpCacheObjects;

class PersonGenerator
{
    private static $id = 0;

    public static function getArray()
    {
        ++static::$id;

        return [
            'id' => static::$id,
            'first_name' => 'First',
            'middle_initial' =>  'M',
            'last_name' => 'Last',
            'date_of_birth' => '1970-01-01',
            'country' => 'BE',

            'field_a' => 'a',
            'field_b' => 'b',
            'field_c' => 'c',
            'field_d' => 'd',
            'field_e' => 'e',
            'field_f' => 'f',
            'field_g' => 'g',
            'field_h' => 'h',
            'field_i' => 'i',
            'field_j' => 'j',
            'field_k' => 'k',
            'field_l' => 'l',
            'field_m' => 'm',
            'field_n' => 'n',
            'field_o' => 'o',
            'field_p' => 'p',
            'field_q' => 'q',
            'field_r' => 'r',
            'field_s' => 's',
            'field_t' => 't',
            'field_u' => 'u',
            'field_v' => 'v',
            'field_w' => 'w',
            'field_x' => 'x',
            'field_y' => 'y',
            'field_z' => 'z',
        ];
    }

    public static function getObject()
    {
        ++static::$id;

        $person = new Person();
        $person->id = static::$id;
        $person->first_name = 'First';
        $person->middle_initial =  'M';
        $person->last_name = 'Last';
        $person->date_of_birth = '1970-01-01';
        $person->country = 'BE';

        $person->field_a = 'a';
        $person->field_b = 'b';
        $person->field_c = 'c';
        $person->field_d = 'd';
        $person->field_e = 'e';
        $person->field_f = 'f';
        $person->field_g = 'g';
        $person->field_h = 'h';
        $person->field_i = 'i';
        $person->field_j = 'j';
        $person->field_k = 'k';
        $person->field_l = 'l';
        $person->field_m = 'm';
        $person->field_n = 'n';
        $person->field_o = 'o';
        $person->field_p = 'p';
        $person->field_q = 'q';
        $person->field_r = 'r';
        $person->field_s = 's';
        $person->field_t = 't';
        $person->field_u = 'u';
        $person->field_v = 'v';
        $person->field_w = 'w';
        $person->field_x = 'x';
        $person->field_y = 'y';
        $person->field_z = 'z';

        return $person;
    }
}
