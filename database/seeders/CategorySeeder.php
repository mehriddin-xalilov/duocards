<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Matematika'],
            ['name' => 'Ingliz tili'],
            ['name' => 'Fizika'],
            ['name' => 'Kimyo'],
            ['name' => 'IT']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
