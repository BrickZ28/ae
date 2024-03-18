<?php

namespace App\Services;

use App\Models\Specials;

class SpecialsService
{
    protected $specials;

    public function __construct(Specials $specials)
    {
        $this->specials = $specials;
    }

    public function getAllSpecials()
    {
        return $this->specials->all();
    }

    public function fetchForCalendar()
    {
        $specials = $this->getAllSpecials();
        $formattedSpecials = [];

        foreach ($specials as $special) {
            $formattedSpecials[] = [
                'title' => $special->title,
                'start' => $special->start_date,
                'end' => $special->end_date,
                'active' => $special->active,
                'description' => $special->description,
            ];
        }

        return response()->json($formattedSpecials);
    }
}
