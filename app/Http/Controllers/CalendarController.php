<?php

namespace App\Http\Controllers;

class CalendarController extends Controller
{
    public function index()
    {
        return view('dashboard.calendar.index'); // Assumes your view is at resources/views/calendar/index.blade.php
    }
}
