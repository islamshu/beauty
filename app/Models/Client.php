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
    // app/Models/Client.php

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where(function ($query) {
                $query->whereNull('end_at')
                    ->orWhere('end_at', '>', now());
            })
            ->whereRaw('total_visit < package_visit');
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription() !== null;
    }
    public function scopeWithActiveSubscription($query)
    {
        return $query->whereHas('activeSubscription');
    }

    // أو إذا كنت تريد دالة ثابتة
    public static function getActiveSubscribers()
    {
        return static::whereHas('activeSubscription')->get();
    }
    public function scopeInactive($query)
    {
        return $query->where(function ($q) {
            // لا يوجد أي اشتراكات
            $q->doesntHave('subscriptions')
                ->orWhereHas('subscriptions', function ($q) {
                    // أو الاشتراكات منتهية الصلاحية
                    $q->where(function ($q) {
                        $q->whereNotNull('end_at')
                            ->where('end_at', '<=', now());
                    })
                        // أو استنفاذ الزيارات
                        ->orWhereRaw('total_visit >= package_visit');
                });
        });
    }

    // دالة مساعدة للتحقق
    public function isInactive()
    {
        return $this->subscriptions()->count() === 0 ||
            $this->subscriptions()
            ->where(function ($q) {
                $q->whereNotNull('end_at')
                    ->where('end_at', '<=', now())
                    ->orWhereRaw('total_visit >= package_visit');
            })
            ->exists();
    }
}
