<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Category;
use App\Models\Level;
use App\Models\Speciality;
use App\Models\Question;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $matematika = Category::where('name','Matematika')->first()->id;
        $ingliz = Category::where('name','Ingliz tili')->first()->id;

        // Levels
        $junior = Level::where('name','Junior')->first()->id;
        $senior = Level::where('name','Senior')->first()->id;

        // Savollar
        $matematikaQuestions = Question::where('category_id', $matematika)->pluck('id')->toArray();
        $inglizQuestions = Question::where('category_id', $ingliz)->pluck('id')->toArray();
        $juniorQuestions = Question::where('level_id', $junior)->pluck('id')->toArray();
        $seniorQuestions = Question::where('level_id', $senior)->pluck('id')->toArray();

        // Testlar
        $tests = [
            // Sertifikat testlari
            [
                'name' => 'Matematika Sertifikat',
                'category_id' => $matematika,
                'level_id' => null,
                'time_limit' => 30,
                'questions_count' => count($matematikaQuestions),
                'randomize_questions' => true,
                'randomize_answers' => true,
                'test_type' => 1,
                'questions' => $matematikaQuestions
            ],
            [
                'name' => 'Ingliz tili Sertifikat',
                'category_id' => $ingliz,
                'level_id' => null,
                'time_limit' => 20,
                'questions_count' => count($inglizQuestions),
                'randomize_questions' => true,
                'randomize_answers' => true,
                'test_type' => 1,
                'questions' => $inglizQuestions
            ],

            // Interview testlari
            [
                'name' => 'Junior PHP Interview',
                'category_id' => null,
                'level_id' => $junior,
                'time_limit' => 30,
                'questions_count' => count($juniorQuestions),
                'randomize_questions' => true,
                'randomize_answers' => true,
                'test_type' => 2,
                'specialities' => [1], // Backend
                'questions' => $juniorQuestions
            ],
            [
                'name' => 'Senior DB Interview',
                'category_id' => null,
                'level_id' => $senior,
                'time_limit' => 30,
                'questions_count' => count($seniorQuestions),
                'randomize_questions' => true,
                'randomize_answers' => true,
                'test_type' => 2,
                'specialities' => [2], // DB
                'questions' => $seniorQuestions
            ],
        ];

        foreach ($tests as $t) {
            $specialities = $t['specialities'] ?? [];
            $questions = $t['questions'] ?? [];
            unset($t['specialities'], $t['questions']); // pivot uchun olib tashlash

            // Test yaratish
            $test = Test::create($t);

            // Speciality bilan bog‘lash (interview testlari)
            if (!empty($specialities)) {
                $test->specialities()->attach($specialities);
            }

            // Savollarni bog‘lash
            if (!empty($questions)) {
                $test->questions()->attach($questions);
            }
        }
    }
}
