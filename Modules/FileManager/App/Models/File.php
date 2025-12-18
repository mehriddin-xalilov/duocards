<?php

namespace Modules\FileManager\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Modules\FileManager\App\Http\Repositories\FileRepository;

class File extends Model
{
    use SoftDeletes;

    protected $casts = [
        'name' => 'array',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp'
    ];
    protected $table = 'files';
    protected $appends = [
        'thumbnails',
    ];
    protected $fillable = [
        'name',
        'title',
        'author',
        'description',
        'slug',
        'ext',
        'file',
        'folder',
        'domain',
        'path',
        'user_id',
        'size',
        'deleted_at',
        'folder_id',

    ];

    protected $hidden = [
        'user_id',
        'domain',
        'created_at',
        'deleted_at',
        'updated_at',
        'path',
    ];

    public function getUrlAttribute(): string
    {
        return trim($this->domain, '/') . '/' . $this->folder . $this->file;
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        static::deleted(function ($file) {
            (new FileRepository())->deleteFile($file);
        });

    }

    public function getThumbnailsAttribute()
    {
        $thumbsImages = config('filemanager.thumbs');
        foreach ($thumbsImages as &$thumbsImage) {
            $slug = $thumbsImage['slug'];
            if (!in_array($this->ext, $this->getImageExtensionsAttribute())) {
                $newFileDist = $this->getUrlAttribute();
            } else {
                $newFileDist = $this->domain . "/" . $this->folder . $this->slug;
                if ($slug != 'original') {
                    $newFileDist .= "_" . $slug;
                }
                $newFileDist .= "." . $this->ext;
            }
            $thumbsImage['src'] = $newFileDist;
            unset($thumbsImage["w"]);
            unset($thumbsImage["h"]);
            unset($thumbsImage["q"]);
        }
        return $thumbsImages;
    }

    public function getImageExtensionsAttribute()
    {
        return config('filemanager.images_ext');
    }

    public function getDist()
    {
        return $this->folder . '/' . $this->file;
    }
    public function getThumbnailUrl(string $size = 'original'): ?string
    {
        $thumbnails = $this->thumbnails;

        foreach ($thumbnails as $thumb) {
            if ($thumb['slug'] === $size) {
                return $thumb['src'];
            }
        }

        return null;
    }
//    public function getNameAttribute($value)
//    {
//        if (!$value) {
//            return [];
//        }
//
//        $data = is_string($value) ? json_decode($value, true) : $value;
//
//        if (!is_array($data)) {
//            return [];
//        }
//        if (Str::contains(request()->path(), 'admin')) {
//            return $data;
//        }
//
//        $locales = [Lang::getLocale(), 'uz', 'oz', 'en', 'ru'];
//
//        foreach ($locales as $locale) {
//            if (isset($data[$locale])) {
//                return $data[$locale];
//            }
//        }
//
//        return array_values($data)[0] ?? '';
//    }


}

