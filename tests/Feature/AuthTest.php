<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

uses(DatabaseTransactions::class)->group('auth');

test('user can log in successfully', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    Log::info($response->getContent());

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ],
        ]);
});

test('login fails with wrong credentials', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure(['status', 'message', 'data', 'errors'])
        ->assertJson([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ]);
});

test('user can log out', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(200)
        ->assertJsonStructure(['status', 'message', 'data', 'errors'])
        ->assertJson(['data' => true]);
});

test('logout fails if user is not authenticated', function () {
    $response = $this->postJson('/api/auth/logout');
    $response->assertStatus(401);
});

test('user can get their profile', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->getJson('/api/auth/user');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
});
