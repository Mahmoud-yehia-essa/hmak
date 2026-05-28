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
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'news_category_id')) {
                $table->unsignedBigInteger('news_category_id')->nullable()->after('id');
                $table->foreign('news_category_id')->references('id')->on('news_category')->onDelete('cascade');
            }
            if (!Schema::hasColumn('news', 'more_des')) {
                $table->longText('more_des')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('news', 'more_des_en')) {
                $table->longText('more_des_en')->nullable()->after('more_des');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'news_category_id')) {
                $table->dropForeign(['news_category_id']);
                $table->dropColumn('news_category_id');
            }
            if (Schema::hasColumn('news', 'more_des')) {
                $table->dropColumn('more_des');
            }
            if (Schema::hasColumn('news', 'more_des_en')) {
                $table->dropColumn('more_des_en');
            }
        });
    }
};
