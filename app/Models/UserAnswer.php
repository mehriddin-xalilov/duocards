<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "user_answers".
*/

class UserAnswer extends Model
{ 
    protected $table = 'user_answers';

    protected $fillable = [
    "id",
    "user_id",
    "question_id",
    "answer_id",
    "is_correct",
    "created_at",
    "updated_at"
];
    
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
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
