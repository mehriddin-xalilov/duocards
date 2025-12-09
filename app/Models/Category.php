<?php

namespace App\Models;

use App\Helpers\Traits\FileableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
* This is the model class for table "categories".
*/

class Category extends Model
{
    use FileableTrait;
    protected mixed $fileableAttributes = ['icon'];
    protected $table = 'categories';

    protected $fillable = [
    "id",
    "name",
    "parent_id",
    "created_at",
    "updated_at"
];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }


}
