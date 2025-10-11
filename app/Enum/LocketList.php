<?php

namespace App\Enum;

enum LocketList: string
{
    case PENDAFTARAN = 'A';
    case LANSIA = 'B';
    case LABORATE = 'C';
    case FARMASI = 'D';

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

    public function soundCategory(): string
    {
        return match ($this) {
            self::PENDAFTARAN, self::LANSIA, self::LABORATE => 'loket',
            self::FARMASI => 'ruang_farmasi',
        };
    }

    public function hasLocketCode(): bool
    {
        return match ($this) {
            self::PENDAFTARAN, self::LANSIA, self::LABORATE => true,
            self::FARMASI => false,
        };
    }
}
