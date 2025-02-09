<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;

uses(DatabaseTransactions::class);

describe('Couriers API without authorization', function () {
    it('returns a list of couriers without authorization')
        ->getJson('/api/couriers')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    it('returns a courier without authorization')
        ->getJson('/api/couriers/5')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});


describe('Couriers API', function () {
    beforeEach(function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    });

    it('returns a list of transport types')
        ->getJson('/api/couriers/transport-types')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'value',
                    'label',
                ]
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a list of availability statuses')
        ->getJson('/api/couriers/availability-statuses')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'value',
                    'label',
                ]
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('returns a list of couriers')
        ->getJson('/api/couriers')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'city_id',
                        'transport_type',
                        'availability_status',
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

    it('returns a courier')
        ->getJson('/api/couriers/5')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'city_id',
                'transport_type',
                'availability_status',
            ],
        ])
        ->assertJsonFragment([
            'status' => 'success',
        ]);

    it('creates a courier')
        ->postJson('/api/couriers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'test@test.com',
            'phone' => '1234567890',
            'city_id' => 1,
            'transport_type' => 1,
            'availability_status' => 1,
        ])
        ->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'city_id',
                'transport_type',
                'availability_status',
            ],
        ]);

    it('updates a courier')
        ->putJson('/api/couriers/5', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'test_update@test.com',
            'phone' => '1234567890',
            'city_id' => 1,
            'transport_type' => 1,
            'availability_status' => 1,
        ])->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'city_id',
                'transport_type',
                'availability_status',
            ],
        ]);

    it('deletes a courier')
        ->deleteJson('/api/couriers/5')
        ->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ]);

    it('returns a list of couriers with a city')
        ->getJson('/api/couriers?city_id=1')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'city_id',
                        'transport_type',
                        'availability_status',
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
});

