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
        Schema::create('team_works', function (Blueprint $table) {
            $table->id();
               $table->string('name')->nullable();
             $table->string('name_en')->nullable();

            $table->text('position')->nullable();
                        $table->text('position_en')->nullable();

            $table->enum('status',['active','inactive'])->default('active');


            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_works');
    }
};
