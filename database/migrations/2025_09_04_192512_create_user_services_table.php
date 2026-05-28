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
        Schema::create('user_services', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('service_id');
    $table->unsignedBigInteger('user_id');
    $table->string('status')->default('pending'); // free text
    $table->text('des')->nullable();
    $table->text('des_en')->nullable();
    $table->string('attach')->nullable(); // user uploaded file
    $table->string('admin_attach')->nullable(); // file uploaded by admin for final service
    $table->timestamps();

    $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_services');
    }
};
