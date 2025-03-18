<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), // عنوان عشوائي
            'price_before_discount' => $this->faker->numberBetween(100, 1000), // سعر قبل الخصم بين 100 و 1000
            'price_after_discount' => $this->faker->numberBetween(50, 500), // سعر بعد الخصم بين 50 و 500
            'small_description' => $this->faker->paragraph(1), // وصف مختصر
            'long_description' => $this->faker->paragraph(3), // وصف طويل
            'image' => 'products/default.png', // صورة افتراضية
            'category_id' => $this->faker->numberBetween(3,4), // معرف الفئة بين 1 و 5
        ];
    }
}