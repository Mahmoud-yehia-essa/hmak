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
        Schema::create('service_comments', function (Blueprint $table) {
          $table->id();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('service_id');
    $table->text('comment');
    $table->string('attach_file')->nullable();
    $table->string('user_role')->nullable(); // corrected from user_roll
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_comments');
    }
};
