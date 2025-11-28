<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * VacancyView Model
 * 
 * Vakansiya ko'rishlarini saqlash uchun model
 * 
 * TODO: Quyidagilarni to'ldirish kerak:
 * - $fillable array
 * - Relationships (vacancy, user)
 * - Scopes (agar kerak bo'lsa)
 */
class VacancyView extends Model
{
    use HasFactory;

    protected $table = 'vacancy_views';

    // TODO: Fillable fields
    protected $fillable = [
        // TODO: Kerakli maydonlarni qo'shing
    ];

    // TODO: Relationships
    // public function vacancy() { ... }
    // public function user() { ... }
}

