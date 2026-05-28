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
        Schema::create('group_subject_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_subject_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['like', 'dislike']);
            
            // Foreign keys
            $table->foreign('group_subject_id')->references('id')->on('group_subjects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Prevent duplicate reactions from the same user on the same subject
            $table->unique(['group_subject_id', 'user_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_subject_reactions');
    }
};
