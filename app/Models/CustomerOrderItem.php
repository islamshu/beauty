<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderItem extends Model
{
    use HasFactory;

    protected $table = 'customer_order_items';

    protected $fillable = ['customer_order_id','product_name', 'product_id', 'quantity', 'price'];

    public function items()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
