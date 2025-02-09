<?php

namespace App\Services;

use App\Http\Resources\AuthResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @throws AuthenticationException
     * @return AuthResource
     */
    public function login(string $email, string $password): AuthResource
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new AuthenticationException('Invalid credentials');
        }

        $user = Auth::user();
        return new AuthResource([
            'user' => $user,
            'token' => $user->createToken('authToken')->plainTextToken,
        ]);
    }

    /**
     * @param $user
     * @return bool
     */
    public function logout($user) : bool
    {
        return (bool)$user->tokens()->delete();
    }
}
