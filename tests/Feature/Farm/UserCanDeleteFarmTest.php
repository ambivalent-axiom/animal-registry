<?php

use App\Models\Farm;
use App\Models\User;

test('user can delete farm', function () {
    $user = User::factory()->create();
    $farm = Farm::factory()->create([
        'user_id' => $user->id,
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
        'user_id' => $user->id,
        'deleted_at' => null,
    ]);
});
