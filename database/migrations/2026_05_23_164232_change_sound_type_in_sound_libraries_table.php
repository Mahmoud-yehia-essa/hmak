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
        Schema::table('sound_libraries', function (Blueprint $table) {
            $table->string('sound_type', 50)->default('recorded')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sound_libraries', function (Blueprint $table) {
            $table->enum('sound_type', ['recorded', 'live', 'report'])->default('recorded')->change();
        });
    }
};
