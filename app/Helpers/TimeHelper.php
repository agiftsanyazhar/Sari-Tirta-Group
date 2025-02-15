<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function convertToUserTimezone($datetime, $timezone)
    {
        return Carbon::parse($datetime)->setTimezone($timezone);
    }
}
