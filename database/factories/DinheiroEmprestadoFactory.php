<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DinheiroEmprestadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'valor' => $this->faker->randomFloat(2, 50, 1000),
            'descricao' => $this->faker->sentence(),
            'data' => $this->faker->date(),
            'nome_cliente' => $this->faker->name(),
            'email_cliente' => $this->faker->safeEmail(),
            'telefone_cliente' => $this->faker->phoneNumber(),
        ];
    }
}
