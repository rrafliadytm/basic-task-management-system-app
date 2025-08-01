<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriesFactory extends Factory
{
    public function definition(): array
    {
        // Create a UNIQUE name
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            // Create a slug based on inputed name
            'slug' => Str::slug($name),
        ];
    }
}
