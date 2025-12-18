<?php

namespace Modules\FileManager\App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'folders';

    protected $fillable = ['id', 'title', 'description', 'slug', 'parent_id', 'status', 'deleted_at', 'created_at', 'updated_at'];

    public static function rules()
    {
        return [
            'id' => 'bigint',
            'title' => 'string',
            'slug' => 'string|nullable',
            'description' => 'string|nullable',
            'status' => 'integer|nullable',
            'parent_id' => 'integer|nullable',
        ];
    }

    public function getChildAttribute()
    {
        return $this->belongsToMany(self::class, ['parent_id' => 'id']);
    }
}
