<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'id_number', 'added_by', 'qr_code'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // الاشتراك النشط (مع مراعاة الحالة التلقائية واليدوية)
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', Subscription::STATUS_ACTIVE)
            ->where(function($query) {
                $query->whereNull('end_at')
                      ->orWhere('end_at', '>', now());
            })
            ->whereRaw('total_visit < package_visit');
    }

    // تحديث جميع حالات اشتراكات العميل
    public function updateSubscriptionsStatus()
    {
        $this->subscriptions()->each(function($subscription) {
            $subscription->updateStatus();
        });
        return $this;
    }

    // التحقق من أن العميل نشط
    public function isActive()
    {
        return $this->activeSubscription()->exists();
    }

    // نطاقات الاستعلام
    public function scopeWithActiveSubscription($query)
    {
        return $query->whereHas('activeSubscription');
    }

    public function scopeInactive($query)
    {
        return $query->where(function($q) {
            $q->doesntHave('subscriptions')
              ->orWhereHas('subscriptions', function($q) {
                  $q->where('status', '!=', Subscription::STATUS_ACTIVE)
                    ->orWhere(function($q) {
                        $q->whereNotNull('end_at')
                          ->where('end_at', '<=', now());
                    })
                    ->orWhereRaw('total_visit >= package_visit');
              });
        });
    }
}