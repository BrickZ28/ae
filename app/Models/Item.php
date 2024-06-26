<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
	use HasFactory;

    protected $guarded = [];


	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'item_package')->withTimestamps();
    }

    public function carts(): BelongsToMany
{
    return $this->belongsToMany(Cart::class, 'cart_items')->withPivot('quantity');
}

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function playstyle()
    {
        return $this->belongsTo(Playstyle::class);
    }
}
