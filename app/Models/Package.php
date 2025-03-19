<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];
    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_service');
    }
}
