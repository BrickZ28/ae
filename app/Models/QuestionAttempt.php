<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionAttempt extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Each attempt belongs to a question
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    // Assuming you're tracking the choice selected in each attempt
    // Each attempt is associated with a choice
    public function choice(): BelongsTo
    {
        return $this->belongsTo(QuestionChoice::class);
    }

    // If attempts are also tied to users, add a user relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
    }
}
