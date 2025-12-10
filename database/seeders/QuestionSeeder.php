<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Category;
use App\Models\Level;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $matematika = Category::where('name','Matematika')->first()->id;
        $ingliz = Category::where('name','Ingliz tili')->first()->id;
        $junior = Level::where('name','Junior')->first()->id;
        $middle = Level::where('name','Middle')->first()->id;
        $senior = Level::where('name','Senior')->first()->id;

        $questions = [
            // Sertifikat testlari
            ['question_text'=>'5 + 7 = ?', 'category_id'=>$matematika, 'level_id'=>null, 'type'=>0],
            ['question_text'=>'Kvadratning maydoni qanday hisoblanadi?', 'category_id'=>$matematika, 'level_id'=>null, 'type'=>0],
            ['question_text'=>'"Hello" so‘zi qaysi tilga tegishli?', 'category_id'=>$ingliz, 'level_id'=>null, 'type'=>0],
            ['question_text'=>'What is the plural of "mouse"?', 'category_id'=>$ingliz, 'level_id'=>null, 'type'=>0],

            // Interview testlari
            ['question_text'=>'PHP da array length qanday olinadi?', 'category_id'=>null, 'level_id'=>$junior, 'type'=>0],
            ['question_text'=>'JavaScriptda promise nima?', 'category_id'=>null, 'level_id'=>$junior, 'type'=>0],
            ['question_text'=>'Laravelda middleware nima vazifa bajaradi?', 'category_id'=>null, 'level_id'=>$middle, 'type'=>0],
            ['question_text'=>'REST API va GraphQL farqi nima?', 'category_id'=>null, 'level_id'=>$middle, 'type'=>0],
            ['question_text'=>'OOP prinsiplaridan abstraction nima?', 'category_id'=>null, 'level_id'=>$senior, 'type'=>0],
            ['question_text'=>'Database indexing nima uchun ishlatiladi?', 'category_id'=>null, 'level_id'=>$senior, 'type'=>0],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
