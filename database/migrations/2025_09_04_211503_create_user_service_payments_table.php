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
        if (!Schema::hasTable('user_service_payments')) {
            Schema::create('user_service_payments', function (Blueprint $table) {
                 $table->id();
                 $table->unsignedBigInteger('user_service_id');
                 $table->decimal('amount', 10, 2);
                 $table->string('status')->default('pending'); // pending, paid, cancelled
                 $table->date('due_date')->nullable();
                 $table->timestamps();

                 $table->foreign('user_service_id')
                     ->references('id')
                     ->on('user_services')
                     ->onDelete('cascade');
             });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_payments');
    }
};
