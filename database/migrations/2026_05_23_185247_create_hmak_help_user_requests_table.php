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
        Schema::create('hmak_help_user_requests', function (Blueprint $table) {
       $table->id();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('hmak_help_category_id');
    $table->text('description')->nullable(); // بديل لـ Des
    $table->text('address')->nullable();
    $table->string('phone');
    $table->string('nationality')->nullable();
    $table->string('current_location')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // بديل لـ request_state

    // العلاقات
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('hmak_help_category_id', 'fk_help_cat_id')->references('id')->on('hmak_help_categories')->onDelete('cascade');
    
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hmak_help_user_requests');
    }
};
