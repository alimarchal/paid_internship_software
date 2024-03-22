<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mathematics', 'description' => 'Algebra, Geometry, Calculus, Statistics'],
            ['name' => 'Science', 'description' => 'Biology, Chemistry, Physics, Earth Science'],
            ['name' => 'Information Technology', 'description' => 'Programming, Network Security, Database Management, Web Development'],
            ['name' => 'Business and Finance', 'description' => 'Accounting, Marketing, Management, Finance'],
            ['name' => 'Analytical', 'description' => 'Skills in analyzing situations and data to solve problems']
            // Add more categories as needed
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
