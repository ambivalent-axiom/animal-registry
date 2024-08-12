<?php

use App\Models\Animal;
use App\Models\Farm;
use App\Models\User;

test('max animals per farm constraint works', function () {
    $user = User::factory()->create();
    $farm  = Farm::factory()->create([
        'user_id' => $user->id,
    ]);
    Animal::factory(3)->create();
    $response = $this
        ->actingAs($user)
        ->post('/animals/create', [
            'farm_id' => $farm->id,
            'animal_number' => 1,
            'type_name' => 'cow',
            'years' => 5
        ]);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(
        ['farm_id' => 'Maximum number of animals per farm is 3']
    );
    $this->assertDatabaseCount('animals', 3);
});
