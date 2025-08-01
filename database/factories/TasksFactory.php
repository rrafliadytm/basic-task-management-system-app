<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Priorities;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => 'pending',
            'user_id' => User::factory(),
            'category_id' => Categories::inRandomOrder()->first()->id,
            'priority_id' => Priorities::inRandomOrder()->first()->id,
        ];
    }
}
