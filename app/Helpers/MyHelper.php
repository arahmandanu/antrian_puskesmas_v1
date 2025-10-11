<?php

namespace App\Helpers;

trait MyHelper
{
    public static function formatNumberQueue($queueNumber)
    {
        $digit = config('mysite.total_locket_queue', 4); // Default to 4 if not set
        return sprintf("%0{$digit}d", $queueNumber);
    }
}
