<?php

namespace App\Helpers;

use App\Utils\Result;

trait ValidateLocketHelper
{
    public static function isALocketByCode($code)
    {
        return preg_match('/^L[A-Z]+$/i', $code) === 1;
    }

    public static function letterToNumber(string $char): ?int
    {
        $char = strtoupper($char); // biar case-insensitive
        if ($char >= 'A' && $char <= 'Z') {
            return ord($char) - ord('A') + 1;
        }
        return null; // kalau bukan huruf
    }
}
