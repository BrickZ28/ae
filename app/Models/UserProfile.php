<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
	protected $fillable = [
		'global_name',
		'profile_photo_path',
		'avatar',
		'banner',
		'local',
		'public_flags',
        'user_id'
	];

	protected function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
