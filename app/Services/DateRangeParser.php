<?php

namespace App\Services;

use Carbon\Carbon;

class DateRangeParser
{
    public function parse($dateRange)
    {
        // Split the date range string by the delimiter (assuming it's '-')
        $dates = explode('-', $dateRange);

        // Trim whitespace from each date
        $startDateStr = trim($dates[0]);
        $endDateStr = trim($dates[1]);

        // Parse start and end dates using Carbon
        $startDate = Carbon::parse($startDateStr);
        $endDate = Carbon::parse($endDateStr);

        return [$startDate, $endDate];
    }

}
