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
        Schema::create('news_eye_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_eye_id');
            $table->foreign('news_eye_id')->references('id')->on('news_eyes')->onDelete('cascade');
            $table->string('visitor_name'); // Visitor's display name
            $table->string('visitor_ip', 45)->nullable(); // IP for moderation
            $table->text('comment');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_eye_comments');
    }
};
