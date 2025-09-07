<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DinheiroEmprestado;

class DinheiroEmprestadoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            DinheiroEmprestado::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}


