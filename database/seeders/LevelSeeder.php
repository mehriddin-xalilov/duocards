<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Junior', 'type' => 0],
            ['name' => 'Middle', 'type' => 0],
            ['name' => 'Senior', 'type' => 0]
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
