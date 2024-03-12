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


	protected function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'item_package');
    }

}
