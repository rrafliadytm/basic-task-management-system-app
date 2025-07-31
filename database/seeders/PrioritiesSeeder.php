<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1],
            ['name' => 'Normal', 'level' => 2],
            ['name' => 'High', 'level' => 3],
            ['name' => 'Urgent', 'level' => 4],
            ['name' => 'Critical', 'level' => 5],
        ];

        foreach ($priorities as $priority) {
            DB::table('priorities')->updateOrInsert(
                ['name' => $priority['name']],
                ['level' => $priority['level'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
