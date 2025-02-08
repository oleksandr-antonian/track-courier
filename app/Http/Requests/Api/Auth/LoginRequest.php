<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class LoginRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.*' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.*' => 'Password is invalid',
        ];
    }
}
