<?php

namespace App\Models;

use App\Traits\Responses\HttpResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Server extends Model
{


	use HasFactory;
    use HttpResponses;

    protected $guarded = [];

    public static function getFromAPI()
    {
        $response = Http::withToken(config('constants.nitrado.api_token'))
            ->accept('application/json')
            ->get('https://api.nitrado.net/services');

        if ($response->successful()) {
            return $response->json();
        } else {
            // Handle the case when the API request fails
            return null;
        }
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Playstyle::class);
    }
}
