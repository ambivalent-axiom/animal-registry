<?php

use App\Models\Animal;
use App\Models\Farm;
use App\Models\User;


test('user can delete farm', function () {
    $user = User::factory()->create();
    $farm = Farm::factory()->create([
        'user_id' => $user->id,
    ]);
    $animal = Animal::factory()->create([
        'user_id' => $user->id,
        'farm_id' => $farm->id,
    ]);
    $response = $this->actingAs($user)
        ->delete("/farms/delete/", [
            'farm_id' => $farm->id,
        ]);
    $response->assertStatus(302);
    $response->assertRedirect("/farms/index");
    $response->assertSessionHas('success', 'Farm has been deleted.');
    $this->assertDatabaseMissing('farms', [
        'id' => $farm->id,
        'deleted_at' => null,
    ]);
    $this->assertDatabaseHas('animals', [
        'id' => $animal->id,
        'deleted_at' => now()->format('Y-m-d H:i:s'),
    ]);
});
