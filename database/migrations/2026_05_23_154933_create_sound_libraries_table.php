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
        Schema::create('sound_libraries', function (Blueprint $table) {
           

            $table->id();
    $table->unsignedBigInteger('sound_library_category_id');
    $table->string('name');
    $table->text('sound_file_path')->nullable(); // يُستخدم في حال رفع ملف مسجل أو تقرير
    $table->text('sound_url')->nullable();      // يُستخدم لرابط البث المباشر (Live) أو روابط البودكاست الخارجية
    $table->enum('sound_type', ['recorded', 'live', 'report'])->default('recorded');
    
    // العلاقة مع جدول الأقسام
    $table->foreign('sound_library_category_id')->references('id')->on('sound_library_categories')->onDelete('cascade');
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sound_libraries');
    }
};
