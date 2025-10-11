<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateRangeHelper
{
    /**
     * Get date range from N days ago to now.
     *
     * @param int $days
     * @return array [Carbon $from, Carbon $to]
     */
    public static function daysAgoToNow(int $days = 2): array
    {
        return [
            Carbon::now()->subDays($days)->startOfDay(),
            Carbon::now()->endOfDay(),
        ];
    }
}
