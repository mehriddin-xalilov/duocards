<?php

namespace App\Models;

use App\Helpers\Traits\FileableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * This is the model class for table "questions".
 */
class Question extends Model
{
    use FileableTrait;
    const TYPE_TEST=0;

    const TYPE_OPEN=1;

    protected $table = 'questions';
    protected mixed $fileableAttributes = ['photo'];
    protected $fillable = [
        "id",
        "level_id",
        "category_id",
        "question_text",
        "type",
        "created_at",
        "updated_at"
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


}
