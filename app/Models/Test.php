<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "tests".
*/

class Test extends Model
{ 
    protected $table = 'tests';

    protected $fillable = [
    "id",
    "name",
    "category_id",
    "level_id",
    "time_limit",
    "questions_count",
    "randomize_questions",
    "randomize_answers",
    "created_at",
    "updated_at"
];
    
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function level(): BelongsTo
	{
		return $this->belongsTo(Level::class);
	}


}
