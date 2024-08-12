<?php

use App\Models\User;


test('user can create farm', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/farms/create', [
            'farm_name' => 'Farm Test',
            'farm_email' => $user->email,
            'farm_website' => 'www.example.com',
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseCount('farms', 1);
    $this->assertDatabaseHas('farms', ['name' => 'Farm Test']);
});
