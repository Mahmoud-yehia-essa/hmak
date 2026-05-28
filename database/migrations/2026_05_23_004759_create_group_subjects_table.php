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
        Schema::create('group_subjects', function (Blueprint $table) {
       $table->id();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('group_id');
    $table->string('title');
    $table->text('description')->nullable();
    $table->unsignedInteger('likes')->default(0);
    $table->unsignedInteger('dislikes')->default(0);
    $table->enum('attachment_type', ['image', 'video', 'audio'])->nullable();
    $table->text('attachment_path')->nullable(); // حقل إضافي مهم لتخزين مسار الملف نفسه
    
    // العلاقات
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
    
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_subjects');
    }
};
