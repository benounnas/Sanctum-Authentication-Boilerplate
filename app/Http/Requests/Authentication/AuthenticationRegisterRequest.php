<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthenticationRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],

            'first_name' => 'nullable|string|min:3',
            'last_name' => 'nullable|string|min:3',
            'phone_number' => 'nullable|string|min:3',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
