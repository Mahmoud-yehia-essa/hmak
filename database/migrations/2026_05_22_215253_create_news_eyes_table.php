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
        Schema::create('news_eyes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('title')->nullable();
                $table->text('content')->nullable();
                $table->text('attachment_path')->nullable();
                $table->enum('attachment_type', ['image', 'video', 'audio'])->nullable();
                $table->string('location')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_eyes');
    }
};
