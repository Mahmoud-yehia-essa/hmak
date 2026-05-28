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
        Schema::create('articles', function (Blueprint $table) {
        $table->id();
    $table->unsignedBigInteger('team_work_id')->nullable(); // كاتب المقال من فريق العمل (تم جعله nullable اختياريًا)
    $table->string('title');
    $table->text('short_description')->nullable(); // الوصف المختصر لقائمة العرض
    $table->longText('long_description')->nullable(); // الوصف الكامل للمقال (استخدام longText أفضل للمقالات الطويلة)
    $table->text('image_path')->nullable(); // صورة غلاف المقال
    
    // العلاقات
    // في حال حذف عضو فريق العمل، سيبقى المقال متاحاً وتصبح قيمة الكاتب null
    $table->foreign('team_work_id')->references('id')->on('team_works')->onDelete('set null');
    
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
