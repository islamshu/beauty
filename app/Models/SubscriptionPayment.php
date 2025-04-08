<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
        'received_by'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}