<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'discord_id' => ['required', 'string'],

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
