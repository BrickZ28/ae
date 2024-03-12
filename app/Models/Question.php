<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function choices(): HasMany
    {
        return $this->hasMany(QuestionChoice::class);
    }

    // Each question can have many attempts
    public function attempts(): HasMany
    {
        return $this->hasMany(QuestionAttempt::class);
    }
}
