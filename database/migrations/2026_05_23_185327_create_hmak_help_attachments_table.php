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
        Schema::create('hmak_help_attachments', function (Blueprint $table) {
           $table->id();
    $table->unsignedBigInteger('hmak_help_user_request_id'); // الاسم البرمجي المنضبط للربط
    $table->text('file_path');
    $table->enum('type', ['image', 'pdf', 'video'])->default('image');

    // العلاقات
    $table->foreign('hmak_help_user_request_id', 'fk_help_req_attach_id')->references('id')->on('hmak_help_user_requests')->onDelete('cascade');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hmak_help_attachments');
    }
};
