<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Farm;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userJanis = User::factory()->create([
            'name' => 'Jānis',
            'email' => 'janis@fermas.lv',
            'password' => Hash::make('qwerty123'),
        ]);
        $userPeteris = User::factory()->create([
            'name' => 'Pēteris',
            'email' => 'peteris@fermas.lv',
            'password' => Hash::make('qwerty123'),
        ]);
        Farm::factory(2)->create([
            'user_id' => $userPeteris->id,
        ]);
        Farm::factory(2)->create([
            'user_id' => $userJanis->id,
        ]);
        Animal::factory(4)->create();
    }
}
