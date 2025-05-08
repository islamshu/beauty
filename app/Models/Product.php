<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // الحقول التي يمكن تعيينها بشكل جماعي (mass assignment)
    protected $fillable = [
        'title',
        'price_after_discount',
        'price_before_discount',
        'small_description',
        'long_description',
        'image',
        'status',
        'category_id',
    ];
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
   // داخل Product.php
public function relatedProducts()
{
    return $this->hasMany(Product::class, 'category_id', 'category_id');
}

    
}
