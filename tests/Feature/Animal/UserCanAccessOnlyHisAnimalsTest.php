<?php

use App\Models\Animal;
use App\Models\Farm;
use App\Models\User;

test('user can access only his animals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user1Farm = Farm::factory()->create(['user_id' => $user1->id]);
    $user2Farm = Farm::factory()->create(['user_id' => $user2->id]);
    $user1Animal = Animal::factory()
        ->create(
            [
            'user_id' => $user1->id,
            'farm_id' => $user1Farm->id
            ]
        );
    $user2Animal = Animal::factory()
        ->create(
            [
            'farm_id' => $user2Farm->id,
            'user_id' => $user2->id
            ]
        );
    $response = $this
        ->actingAs($user1)
        ->get('/animals/update/' . $user1Animal->id);
    $response->assertStatus(200);
    $response = $this
        ->actingAs($user1)
        ->get('/animals/update/' . $user2Animal->id);
    $response->assertStatus(401);
});
