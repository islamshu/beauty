<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['service_id', 'idnumber','date', 'full_name', 'phone', 'address'];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
