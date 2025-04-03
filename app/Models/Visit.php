<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'visit_date',
        'package_id',
        'notes',
        'subscription_id'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supervisor() // user who supervised the visit
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
