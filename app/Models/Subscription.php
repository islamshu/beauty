<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
