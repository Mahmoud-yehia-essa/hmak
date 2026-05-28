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
        Schema::table('user_services', function (Blueprint $table) {
             $table->decimal('total_price', 10, 2)->nullable()->after('admin_attach');
            $table->integer('payments_count')->nullable()->after('total_price');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('payments_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_services', function (Blueprint $table) {
            //
        });
    }
};
