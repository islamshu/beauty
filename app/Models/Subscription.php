<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('end_at')
                ->orWhere('end_at', '>', now());
        })
            ->whereRaw('total_visit < package_visit');
    }
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
    public function isActive()
    {
        return ($this->end_at === null || $this->end_at > now()) &&
            ($this->total_visit < $this->package_visit);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class,'subscription_id');
    }
}
