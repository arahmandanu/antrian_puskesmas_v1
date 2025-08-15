<?php

namespace App\Enum;

enum CodeServiceEnum: string
{
    case TELLER = 'A';
    case CS = 'B';
    case PEGADAIAN = 'C';

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }
}
