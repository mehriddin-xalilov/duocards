<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


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
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(
            Question::class,
            'test_questions',
            'test_id',
            'question_id'
        )->withTimestamps();
    }


    public function specialities(): BelongsToMany
    {
        return $this->belongsToMany(Speciality::class, 'speciality_test', 'test_id', 'speciality_id');
    }


}
