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
            ['name' => 'Normal', 'level' => 1],
            ['name' => 'High', 'level' => 2],
            ['name' => 'Urgent', 'level' => 3],
            ['name' => 'Low', 'level' => 4],
        ];

        foreach ($priorities as $priority) {
            DB::table('priorities')->updateOrInsert(
                ['name' => $priority['name']],
                ['level' => $priority['level'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
