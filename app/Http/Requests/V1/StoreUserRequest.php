<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['required', 'confirmed', Password::default()],
            'remember_token' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
