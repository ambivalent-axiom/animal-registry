<?php

use App\Models\Farm;
use App\Models\User;

test('example', function () {
    $user = User::factory()->create();
    $farm = Farm::factory()->create([
        'user_id' => $user->id,
    ]);
    $response = $this->actingAs($user)
        ->put('farms/update',
            [
                'farm_id' => $farm->id,
                'name' => 'Updated Farm',
                'email' => 'updated@example.com',
                'website' => 'www.updated.com',
            ]
        );
    $response->assertStatus(302);
    $response->assertRedirect("/farms/index");
    $response->assertSessionHas('success', 'Farm has been updated.');
    $this->assertDatabaseCount('farms', 1);
    $this->assertDatabaseHas('farms', [
        'id' => $farm->id,
        'name' => 'Updated Farm',
        'email' => 'updated@example.com',
        'website' => 'www.updated.com',
    ]);
});
