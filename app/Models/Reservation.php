<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['title', 'start', 'end', 'nots', 'client_id', 'user_id', 'phone_number', 'reason'];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'reservation_service', 'reservation_id', 'service_id');
    }

}
