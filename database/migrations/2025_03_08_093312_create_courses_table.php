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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الكورس
            $table->text('description')->nullable(); // وصف الكورس
            $table->decimal('price', 8, 2); // سعر الكورس
            $table->string('image')->nullable(); // صورة الكورس
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // الفئة
            $table->boolean('status')->default(1); // حالة الكورس
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
