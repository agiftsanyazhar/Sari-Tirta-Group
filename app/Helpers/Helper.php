<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helper
{
    public static function convertToUserTimezone($datetime, $timezone)
    {
        return Carbon::parse($datetime)->setTimezone($timezone);
    }

    public static function isWorkingHours($time)
    {
        return $time->hour > 7 && $time->hour < 18;
    }
}
