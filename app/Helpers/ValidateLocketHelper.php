<?php

namespace App\Helpers;

use App\Utils\Result;

trait ValidateLocketHelper
{
    public static function isALocketByCode($code)
    {
        return preg_match('/^L[0-9]+$/i', $code) === 1;
    }
}
