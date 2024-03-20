<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
	use HasFactory;

    protected $guarded = [];

	protected function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'cart_items')
            ->withPivot('quantity')
            ->withTimestamps();
    }


}
