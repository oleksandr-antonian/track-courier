<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\ResponseApiResource;
use App\Http\Resources\Api\UserResource;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return ResponseApiResource
     */
    public function login(LoginRequest $request): ResponseApiResource
    {
        try {
            $validated = $request->validated();
            return new ResponseApiResource(
                $this->authService->login($validated['email'], $validated['password']),
                'Login successful'
            );
        } catch (AuthenticationException $e) {
            return new ResponseApiResource(null, 'Invalid credentials', $e->getMessage(), 422);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return ResponseApiResource
     */
    public function logout(Request $request): ResponseApiResource
    {
        try {
            $user = $request->user();
            $this->authService->logout($user);
            return new ResponseApiResource(true, 'Logout successful');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return ResponseApiResource
     */
    public function user(Request $request): ResponseApiResource
    {
        return new ResponseApiResource(new UserResource($request->user()), 'User data');
    }
}
