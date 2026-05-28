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
        Schema::create('plannes', function (Blueprint $table) {
            $table->id();
               $table->string('title')->nullable();
             $table->string('title_en')->nullable();

            $table->text('des')->nullable();
            $table->text('des_en')->nullable();


                        $table->text('service')->nullable();
                        $table->text('service_en')->nullable();


                            $table->text('hint')->nullable();
                        $table->text('hint_en')->nullable();

            $table->double('price', 8, 2); // changed from integer to double


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannes');
    }
};
