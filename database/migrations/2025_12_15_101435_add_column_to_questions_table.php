<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->tinyInteger('test_type')
                ->default(1)  // Default: sertifikat
                ->after('type')
                ->comment('1=Sertifikat, 2=Interview');
            $table->index('test_type');
            $table->index(['test_type', 'category_id']);
            $table->index(['test_type', 'level_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['test_type']);
            $table->dropIndex(['test_type', 'category_id']);
            $table->dropIndex(['test_type', 'level_id']);
            $table->dropColumn('test_type');
        });
    }
};
