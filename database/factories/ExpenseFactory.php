<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake()->name(),
            'date' => fake()->date(),
            'value' => fake()->randomFloat(2, 1, 1500)
        ];
    }
}
