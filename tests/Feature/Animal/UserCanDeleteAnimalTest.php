<?php

use App\Models\Animal;
use App\Models\Farm;
use App\Models\User;

test('user can delete animal', function () {
    $user = User::factory()->create();
    $farm = Farm::factory()->create([
        'user_id' => $user->id,
    ]);
    $animal = Animal::factory()->create([
        'user_id' => $user->id,
        'farm_id' => $farm->id,
    ]);
    $response = $this->actingAs($user)
        ->delete("/animals/delete/" . $animal->id);

    $this->assertDatabaseMissing('animals', [
        'id' => $animal->id,
        'user_id' => $user->id,
        'farm_id' => $farm->id,
        'deleted_at' => null,
    ]);
    $response->assertRedirect("/farms/index");
    $response->assertSessionHas('success', 'Animal has been removed.');
    $response->assertStatus(302);
});
