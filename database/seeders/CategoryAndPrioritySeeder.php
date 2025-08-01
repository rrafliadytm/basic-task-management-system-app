<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Priorities;
use Illuminate\Database\Seeder;

class CategoryAndPrioritySeeder extends Seeder
{
    public function run(): void
    {
        Categories::factory()->create(['name' => 'Pekerjaan']);
        Priorities::factory()->create(['name' => 'Tinggi']);
    }
}
