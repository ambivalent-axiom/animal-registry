<?php

use App\Models\User;

test('user can create farm', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/farms/create', [
            'user_id' => $user->id,
            'name' => 'Farm Test',
            'email' => $user->email,
            'website' => 'www.example.com',
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseCount('farms', 1);
    $this->assertDatabaseHas('farms', ['name' => 'Farm Test']);
});
