<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    
    // الحالات الممكنة للاشتراك
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_EXPIRED = 'expired';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

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

    public function visits()
    {
        return $this->hasMany(Visit::class, 'subscription_id');
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    // تحديد الحالة التلقائية بناءً على التاريخ والزيارات
    public function determineStatus()
    {
        if ($this->status === self::STATUS_CANCELED || $this->status === self::STATUS_SUSPENDED) {
            return $this->status; // الحالات اليدوية لا تتغير تلقائياً
        }

        if ($this->total_visit >= $this->package_visit) {
            return self::STATUS_COMPLETED;
        }

        if ($this->end_at && $this->end_at <= now()) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_ACTIVE;
    }

    // تحديث الحالة تلقائياً
    public function updateStatus()
    {
        $newStatus = $this->determineStatus();
        if ($newStatus !== $this->status) {
            $this->update(['status' => $newStatus]);
        }
        return $this;
    }

    // التحقق من أن الاشتراك نشط (مع مراعاة الحالة اليدوية)
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE && 
               ($this->end_at === null || $this->end_at > now()) &&
               ($this->total_visit < $this->package_visit);
    }

    // طرق التحكم اليدوية
    public function activate()
    {
        if ($this->determineStatus() === self::STATUS_ACTIVE) {
            $this->update(['status' => self::STATUS_ACTIVE]);
        }
        return $this;
    }

    public function suspend()
    {
        $this->update(['status' => self::STATUS_SUSPENDED]);
        return $this;
    }

    public function cancel()
    {
        $this->update(['status' => self::STATUS_CANCELED]);
        return $this;
    }

    // نطاقات الاستعلام
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->where(function($q) {
                $q->whereNull('end_at')
                  ->orWhere('end_at', '>', now());
            })
            ->whereRaw('total_visit < package_visit');
    }

    public function scopeManualOverride($query)
    {
        return $query->whereIn('status', [self::STATUS_SUSPENDED, self::STATUS_CANCELED]);
    }
}