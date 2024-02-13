<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
	use HasFactory;

    protected $fillable = ['name', 'ip'];

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
