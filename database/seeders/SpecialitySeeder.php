<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speciality;

class SpecialitySeeder extends Seeder
{
    public function run(): void
    {
        $specialities = [
            ['name' => 'Backend'],
            ['name' => 'Frontend'],
            ['name' => 'Database'],
            ['name' => 'DevOps'],
            ['name' => 'Python'],
        ];

        foreach ($specialities as $s) {
            Speciality::create($s);
        }
    }
}
