<?php

namespace App\Models;

use App\Helpers\Traits\FileableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * This is the model class for table "questions".
 */
class Question extends Model
{
    use FileableTrait;
    // ========== INPUT TYPE ==========
    const TYPE_TEST = 0;      // Multiple choice
    const TYPE_OPEN = 1;      // Open-ended (text)

    // ========== TEST TYPE ==========
    const TEST_TYPE_CERTIFICATE = 1;  // Sertifikat testi
    const TEST_TYPE_INTERVIEW = 2;    // Ishga kirish suhbat testi

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
    protected $casts = [
        'type' => 'integer',
        'test_type' => 'integer',
    ];

    // ========== CONSTANTS ==========
    public static array $inputTypes = [
        self::TYPE_TEST => 'Multiple Choice',
        self::TYPE_OPEN => 'Open Ended'
    ];

    public static array $testTypes = [
        self::TEST_TYPE_CERTIFICATE => 'Sertifikat',
        self::TEST_TYPE_INTERVIEW => 'Ishga Kirish'
    ];
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'test_questions', 'question_id', 'test_id');
    }
    /**
     * Interview savollarini olish
     */
    public function scopeInterview($query)
    {
        return $query->where('test_type', self::TEST_TYPE_INTERVIEW);
    }

    /**
     * Kategori bo'yicha savollarni olish
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }


    /**
     * Daraja bo'yicha savollarni olish
     */
    public function scopeByLevel($query, $levelId)
    {
        return $query->where('level_id', $levelId);
    }

    /**
     * Multiple choice savollarni olish
     */
    public function scopeMultipleChoice($query)
    {
        return $query->where('type', self::TYPE_TEST);
    }

    /**
     * Open-ended savollarni olish
     */
    public function scopeOpenEnded($query)
    {
        return $query->where('type', self::TYPE_OPEN);
    }


}
