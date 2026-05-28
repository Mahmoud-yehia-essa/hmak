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
        Schema::create('news_eye_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_eye_id');
            $table->foreign('news_eye_id')->references('id')->on('news_eyes')->onDelete('cascade');
            $table->string('visitor_ip', 45); // visitor IP for uniqueness
            $table->tinyInteger('rating')->unsigned(); // 1 to 5
            $table->timestamps();
            
            // Unique: one rating per IP per news
            $table->unique(['news_eye_id', 'visitor_ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_eye_ratings');
    }
};
