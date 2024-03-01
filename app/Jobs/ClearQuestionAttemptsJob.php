<?php

namespace App\Jobs;

use App\Models\QuestionAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearQuestionAttemptsJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public function __construct()
	{
	}

	public function handle(): void
	{
        // Clear all question attempts
        QuestionAttempt::truncate();
	}
}
