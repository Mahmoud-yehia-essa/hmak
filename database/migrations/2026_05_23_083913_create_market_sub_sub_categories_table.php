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
        Schema::create('market_sub_sub_categories', function (Blueprint $table) {
     

            $table->id();
    $table->unsignedBigInteger('market_sub_category_id');
    $table->string('name');
    $table->text('description')->nullable();
    $table->text('image_path')->nullable();

    // العلاقات
    $table->foreign('market_sub_category_id')->references('id')->on('market_sub_categories')->onDelete('cascade');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_sub_sub_categories');
    }
};
