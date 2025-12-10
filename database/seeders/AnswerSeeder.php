<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        $answers = [
            1 => ['12','10','11','13'],
            2 => ['tomon²','2×tomon','4×tomon','tomon×2'],
            3 => ['English','French','Russian','Spanish'],
            4 => ['mice','mouses','mousees','mices'],
            5 => ['count($array)','length($array)','sizeof($array)','$array->length'],
            6 => ['Object that resolves later','Function','Variable','Array'],
            7 => ['Request filter','Controller','Model','Route'],
            8 => ['REST uses HTTP, GraphQL uses queries','Both same','REST faster','GraphQL slower'],
            9 => ['Hide implementation details','Make object','Bind data','Delete object'],
            10 => ['Speed up queries','Encrypt data','Delete table','Store images'],
        ];

        foreach ($answers as $qid => $ans) {
            foreach ($ans as $index => $text) {
                \App\Models\Answer::create([
                    'question_id'=>$qid,
                    'answer_text'=>$text,
                    'is_correct'=>$index===0 ? true : false,
                    'type'=>0
                ]);
            }
        }
    }
}
