<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendasRealizadaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'produto' => $this->faker->word(),
            'quantidade' => $this->faker->numberBetween(1, 10),
            'data' => $this->faker->date(),
            'nome_cliente' => $this->faker->name(),
            'email_cliente' => $this->faker->safeEmail(),
            'telefone_cliente' => $this->faker->phoneNumber(),
        ];
    }
}
