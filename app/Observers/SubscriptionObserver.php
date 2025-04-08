<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function saving(Subscription $subscription)
    {
        // تحديث الحالة تلقائياً عند أي تغيير إلا إذا كانت حالة يدوية
        if (!in_array($subscription->status, [Subscription::STATUS_SUSPENDED, Subscription::STATUS_CANCELED])) {
            $subscription->status = $subscription->determineStatus();
        }
    }

    public function created(Subscription $subscription)
    {
        $subscription->client->updateSubscriptionsStatus();
    }

    public function updated(Subscription $subscription)
    {
        if ($subscription->isDirty('status')) {
            $subscription->client->updateSubscriptionsStatus();
        }
    }
}