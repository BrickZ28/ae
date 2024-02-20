<?php

namespace App\Services;

use Carbon\Carbon;

class DateRangeParser
{
    public function parse($dateRange)
    {
        // Extract start and end dates from the range
        [$startDateStr, $endDateStr] = explode(' - ', $dateRange);

        // Convert start and end date strings to Carbon objects
        $startDate = Carbon::createFromFormat(config('constants.date.form_format'), $startDateStr);
        $endDate = Carbon::createFromFormat(config('constants.date.form_format'), $endDateStr);

        // Return the Carbon objects
        return [$startDate, $endDate];
    }

}
