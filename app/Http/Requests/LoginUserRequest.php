<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [

//            'email' => ['required', 'email', 'string'],

        ];
    }

    public function authorize(): bool
    {
        return false;
    }
}
