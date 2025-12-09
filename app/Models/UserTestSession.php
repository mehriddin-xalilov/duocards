<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "user_test_sessions".
*/

class UserTestSession extends Model
{ 
    protected $table = 'user_test_sessions';

    protected $fillable = [
    "id",
    "user_id",
    "test_id",
    "started_at",
    "finished_at",
    "score",
    "correct_answers",
    "wrong_answers",
    "status",
    "created_at",
    "updated_at"
];
    
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function test(): BelongsTo
	{
		return $this->belongsTo(Test::class);
	}


}
