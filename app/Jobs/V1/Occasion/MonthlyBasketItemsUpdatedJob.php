<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Inventory;
use App\Models\User;
use App\Notifications\Occasion\MonthlyBasketItemsUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class MonthlyBasketItemsUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        ray('hay');
        Inventory::chunk(200, function ($models) {
            $models->searchable();
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['update_monthly_basket'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new MonthlyBasketItemsUpdatedNotification(
                user: $this->user
            )
        );
    }
}
