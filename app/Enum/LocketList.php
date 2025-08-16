<?php

namespace App\Enum;

enum LocketList: string
{
    case PENDAFTARAN = 'A';
    case LANSIA = 'B';
    case LABORATE = 'C';

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }

    public static function allIntoString()
    {
        return implode(',', self::toArray());
    }
}
