<?php

use App\Models\Farm;
use App\Models\User;

test('user can access only his farm', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user1Farm = Farm::factory()->create(['user_id' => $user1->id]);
    $user2Farm = Farm::factory()->create(['user_id' => $user2->id]);
    $response = $this
        ->actingAs($user1)
        ->get('/farms/show/' . $user1Farm->id);
    $response->assertStatus(200);
    $response = $this
        ->actingAs($user1)
        ->get('/farms/show/' . $user2Farm->id);
    $response->assertStatus(401);
});
