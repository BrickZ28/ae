<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItems extends Model
{
	use HasFactory;

    protected $guarded = [];

	protected function carts(): BelongsTo
	{
		return $this->belongsTo(Carts::class);
	}

	protected function item(): BelongsTo
	{
		return $this->belongsTo(Item::class);
	}
}
