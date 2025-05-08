<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customer_orders'; // تحديد اسم الجدول

    protected $fillable = ['area_id','area','customer_name', 'customer_phone','customer_id','customer_id','customer_address', 'total_price'];

    public function items()
    {
        return $this->hasMany(CustomerOrderItem::class);
    }
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->customer_id = 1;
        });
    }
   
    public function area_price()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
