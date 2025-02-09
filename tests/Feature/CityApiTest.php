<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;

uses(DatabaseTransactions::class);

describe('Cities API without authorization', function () {
    it('returns a list of cities without authorization')
        ->getJson('/api/cities')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    it('returns a city without authorization')
        ->getJson('/api/cities/1')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});

describe('Cities API', function () {
    beforeEach(function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    });

    it('returns a list of cities')
        ->getJson('/api/cities')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'country_id',
                    ]
                ],
                'current_page',
                'total',
                'per_page',
                'last_page',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a city')
        ->getJson('/api/cities/1')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'country_id'
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a list of cities with a country')
        ->getJson('/api/cities?country_id=1')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'country_id',
                    ]
                ],
                'current_page',
                'total',
                'per_page',
                'last_page',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a 404 error if the city does not exist')
        ->getJson('/api/cities/100000')
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message',
            'errors',
        ])
        ->assertJsonFragment([
            'status' => 'error',
        ]);
});
