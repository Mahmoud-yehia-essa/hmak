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
        Schema::create('user_service_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_service_id'); // ربط بالجدول الرئيسي
            $table->decimal('amount', 10, 2); // قيمة الدفعة
            $table->enum('status', ['pending', 'paid'])->default('pending'); // حالة الدفع
            $table->date('due_date')->nullable(); // تاريخ استحقاق الدفع
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->timestamps();

            $table->foreign('user_service_id')->references('id')->on('user_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_payments');
    }
};
