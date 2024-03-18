<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Playstyle extends Model
{
    protected $guarded = [];

    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
    }
}
