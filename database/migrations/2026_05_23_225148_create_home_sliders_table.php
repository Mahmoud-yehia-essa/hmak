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
        Schema::create('home_sliders', function (Blueprint $table) {
           
$table->id();
    $table->string('title')->nullable(); // جعل العنوان اختيارياً في حال رغبت بعرض الصورة/الفيديو كاملة بدون نص
    $table->text('description')->nullable(); // بديل لـ Des
    $table->text('attachment_path'); // مسار ملف الصورة أو الفيديو
    $table->enum('attachment_type', ['image', 'video'])->default('image'); // تحديد نوع المرفق
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sliders');
    }
};
