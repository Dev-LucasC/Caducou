<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VendasRealizada;

class VendasRealizadaSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            VendasRealizada::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
