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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('price_after_discount');
            $table->double('price_before_discount');
            $table->string('image');
            $table->mediumText('small_description');
            $table->text('long_description');
            $table->integer('status')->default(1);
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // الفئة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
