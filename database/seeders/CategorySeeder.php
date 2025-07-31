<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Office Work', 'slug' => 'office-work'],
            ['name' => 'Personal Project', 'slug' => 'personal-project'],
            ['name' => 'Household Chores', 'slug' => 'household-chores'],
            ['name' => 'Learning and Self Improvement', 'slug' => 'learning-and-self-improvement'],
            ['name' => 'Health and Fitness', 'slug' => 'health-and-fitness'],
            ['name' => 'Travel and Adventure', 'slug' => 'travel-and-adventure'],
            ['name' => 'Finance and Budgeting', 'slug' => 'finance-and-budgeting'],
            ['name' => 'Information Technology', 'slug' => 'information-technology'],
        ];
        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category['name']],
                ['slug' => $category['slug'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
