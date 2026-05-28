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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();

               $table->string('title')->nullable();
             $table->string('title_en')->nullable();

            $table->text('des')->nullable();
            $table->text('des_en')->nullable();

            $table->string('photo')->nullable();

            $table->text('video')->nullable();
            $table->integer('number')->nullable();;

            $table->enum('role',['header','about','service','company_works','footer_post'])->default('header');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};
