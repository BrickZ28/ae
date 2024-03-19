<?php

use App\Jobs\ApplyAeCreditsJob;
use App\Jobs\ClearQuestionAttemptsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new ApplyAeCreditsJob())->weekly();
Schedule::job(new ClearQuestionAttemptsJob())->daily();
