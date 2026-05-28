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
        Schema::create('group_comments', function (Blueprint $table) {
          $table->id();
    $table->unsignedBigInteger('group_subject_id');
    $table->unsignedBigInteger('user_id');
    $table->text('content')->nullable(); // نص التعليق
    $table->enum('attachment_type', ['image', 'video', 'audio'])->nullable();
    $table->text('attachment_path')->nullable(); // مسار ملف التعليق إن وجد
    
    // العلاقات
    $table->foreign('group_subject_id')->references('id')->on('group_subjects')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_comments');
    }
};
