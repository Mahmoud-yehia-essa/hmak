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
        Schema::create('market_item_attachments', function (Blueprint $table) {
     
            $table->id();
    $table->unsignedBigInteger('market_item_id');
    $table->string('attachment_name')->nullable();
    $table->text('attachment_path'); // الحقل الفعلي لتخزين مسار الملف
    $table->enum('type', ['image', 'video'])->default('image');

    // العلاقات
    $table->foreign('market_item_id')->references('id')->on('market_items')->onDelete('cascade');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_item_attachments');
    }
};
