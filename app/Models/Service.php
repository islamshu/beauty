<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title', 'description', 'price', 'category_id', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_service', 'service_id', 'reservation_id');
    }
}
