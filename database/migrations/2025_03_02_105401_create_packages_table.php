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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('number_date');
            $table->string('type_date');
            $table->string('price');
            $table->string('description');
            $table->integer('status')->default(1);
            $table->string('number_of_users_type');
            $table->integer('number_of_users')->nullable();
            $table->integer('number_of_visits');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
