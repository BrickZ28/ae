<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Rule */
class RuleResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'rule' => $this->rule,
			'priority' => $this->priority,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			'user_id' => $this->user_id,
		];
	}
}
