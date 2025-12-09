<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "user_test_answers".
*/

class UserTestAnswer extends Model
{ 
    protected $table = 'user_test_answers';

    protected $fillable = [
    "id",
    "session_id",
    "test_id",
    "question_id",
    "answer_id",
    "is_correct",
    "answered_at",
    "created_at",
    "updated_at"
];
    
	public function session(): BelongsTo
	{
		return $this->belongsTo(UserTestSession::class);
	}

	public function test(): BelongsTo
	{
		return $this->belongsTo(Test::class);
	}

	public function question(): BelongsTo
	{
		return $this->belongsTo(Question::class);
	}

	public function answer(): BelongsTo
	{
		return $this->belongsTo(Answer::class);
	}


}
