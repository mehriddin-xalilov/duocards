<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "answers".
*/

class Answer extends Model
{ 
    protected $table = 'answers';

    protected $fillable = [
    "id",
    "question_id",
    "answer_text",
    "is_correct",
    "type",
    "created_at",
    "updated_at"
];
    
	public function question(): BelongsTo
	{
		return $this->belongsTo(Question::class);
	}


}
