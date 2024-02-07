<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuleRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'rule' => ['required'],
			'priority' => ['required', 'integer'],
//			'user_id' => ['nullable', 'exists:users'],
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
