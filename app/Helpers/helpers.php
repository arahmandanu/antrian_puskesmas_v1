<?php

if (!function_exists('humanize_seconds')) {
    function humanize_seconds($seconds)
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;

        if ($minutes > 0) {
            return $seconds > 0 ? "{$minutes} min and {$seconds} s" : "{$minutes} min";
        }
        return "{$seconds} s";
    }
}
