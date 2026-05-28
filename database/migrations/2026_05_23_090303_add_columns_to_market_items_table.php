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
        Schema::table('market_items', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->decimal('price', 10, 2)->nullable()->after('description');
            $table->string('image_path')->nullable()->after('price');
            
            $table->unsignedBigInteger('market_main_category_id')->nullable()->after('image_path');
            $table->unsignedBigInteger('market_sub_category_id')->nullable()->after('market_main_category_id');
            $table->unsignedBigInteger('market_sub_sub_category_id')->nullable()->after('market_sub_category_id');
            
            $table->enum('status', ['active', 'inactive'])->default('active')->after('market_sub_sub_category_id');

            // Foreign Keys
            $table->foreign('market_main_category_id')->references('id')->on('market_main_categories')->onDelete('cascade');
            $table->foreign('market_sub_category_id')->references('id')->on('market_sub_categories')->onDelete('cascade');
            $table->foreign('market_sub_sub_category_id')->references('id')->on('market_sub_sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('market_items', function (Blueprint $table) {
            $table->dropForeign(['market_main_category_id']);
            $table->dropForeign(['market_sub_category_id']);
            $table->dropForeign(['market_sub_sub_category_id']);
            
            $table->dropColumn([
                'name',
                'description',
                'price',
                'image_path',
                'market_main_category_id',
                'market_sub_category_id',
                'market_sub_sub_category_id',
                'status'
            ]);
        });
    }
};
