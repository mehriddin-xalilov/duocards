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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('slug')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreignId('folder_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->index('folder_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
