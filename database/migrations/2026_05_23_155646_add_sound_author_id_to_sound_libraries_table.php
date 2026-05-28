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
            // 1. إضافة حقل المعرف بعد حقل القسم وجعله nullable تفادياً للمشاكل إذا كان الجدول يحتوي على بيانات برمجية سابقة
            $table->unsignedBigInteger('sound_author_id')->nullable()->after('sound_library_category_id');
            
            // 2. ربط الحقل كعلاقة مع جدول مؤلفي الصوتيات
            $table->foreign('sound_author_id')->references('id')->on('sound_authors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sound_libraries', function (Blueprint $table) {
            // 1. حذف العلاقة أولاً (خطوة إجبارية في قواعد البيانات قبل حذف العمود نفسه)
            $table->dropForeign(['sound_author_id']);
            
            // 2. حذف العمود من الجدول
            $table->dropColumn('sound_author_id');
        });
    }
};