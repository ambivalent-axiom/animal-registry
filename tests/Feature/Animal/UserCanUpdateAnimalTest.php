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
        ->put("/animals/update", [
            'animal_id' => $animal->id,
            'animal_number' => 1,
            'type_name' => 'cow',
            'years' => 3
        ]);
    $response->assertStatus(302);
    $response->assertRedirect("/farms/index");
    $response->assertSessionHas('success', 'Animal has been updated.');
    $this->assertDatabaseCount('animals', 1);
    $this->assertDatabaseHas('animals', [
        'id' => $animal->id,
        'animal_number' => 1,
        'type_name' => 'cow',
        'years' => 3
    ]);
});
