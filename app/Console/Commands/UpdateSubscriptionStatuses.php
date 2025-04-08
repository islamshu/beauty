<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class UpdateSubscriptionStatuses extends Command
{
    protected $signature = 'subscriptions:update-statuses';
    protected $description = 'Update subscription statuses automatically';

    public function handle()
    {
        Subscription::whereNotIn('status', [Subscription::STATUS_SUSPENDED, Subscription::STATUS_CANCELED])
            ->chunk(100, function ($subscriptions) {
                foreach ($subscriptions as $subscription) {
                    $subscription->updateStatus();
                }
            });

        $this->info('Subscription statuses updated successfully.');
    }
}