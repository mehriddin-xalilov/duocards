<?php

namespace App\Models;

use App\Helpers\Traits\FileableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
* This is the model class for table "levels".
*/

class Level extends Model
{
    use FileableTrait;
    protected mixed $fileableAttributes = ['icon'];
    protected $table = 'levels';

    protected $fillable = [
    "id",
    "name",
    "type",
    "created_at",
    "updated_at"
];
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }


}
