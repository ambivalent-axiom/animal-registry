<?php

use App\Models\Farm;
use App\Models\User;

test('user can add animal to farm', function () {
    $user = User::factory()->create();
    $farm  = Farm::factory()->create([
        'user_id' => $user->id,
    ]);
    $response = $this
        ->actingAs($user)
        ->post('/animals/create', [
            'farm_id' => $farm->id,
            'animal_number' => 1,
            'type_name' => 'cow',
            'years' => 5
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseCount('animals', 1);
    $this->assertDatabaseHas('animals', ['type_name' => 'cow']);
});
