<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Vacancy Views Migration
 * 
 * TODO: Quyidagilarni to'ldirish kerak:
 * - Jadval strukturasini yaratish
 * - Index'lar qo'shish
 * - Foreign key'lar qo'shish
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vacancy_views', function (Blueprint $table) {
            // TODO: Jadval strukturasini yaratish
            // $table->id();
            // $table->bigInteger('vacancy_id');
            // ...
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_views');
    }
};

