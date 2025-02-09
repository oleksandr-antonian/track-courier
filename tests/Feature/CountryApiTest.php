<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;

uses(DatabaseTransactions::class);

describe('Countries API without authorization', function () {
it('returns a list of countries without authorization')
    ->getJson('/api/countries')
    ->assertStatus(401)
    ->assertJson([
        'message' => 'Unauthenticated.',
    ]);
it('returns a country without authorization')
    ->getJson('/api/countries/1')
    ->assertStatus(401)
    ->assertJson([
        'message' => 'Unauthenticated.',
    ]);
});

describe('Countries API', function () {
    beforeEach(function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    });

    it('returns a list of countries')
        ->getJson('/api/countries')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'iso_alpha_2',
                        'iso_alpha_3'
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

    it('returns a country')
        ->getJson('/api/countries/1')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'iso_alpha_2',
                'iso_alpha_3'
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a 404 error if the country does not exist')
        ->getJson('/api/countries/100000')
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
