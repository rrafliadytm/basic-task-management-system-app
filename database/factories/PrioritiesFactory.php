<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrioritiesFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Add unique() to ensure priority names are not duplicated
            'name' => fake()->unique()->word(),
            'level' => fake()->numberBetween(1, 5)
        ];
    }
}
