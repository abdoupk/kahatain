<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Inventory;
use App\Models\User;
use App\Notifications\Occasion\RamadanBasketItemsUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class RamadanBasketItemsUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        Inventory::chunk(200, function ($models): void {
            $models->searchable();
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['update_ramadan_basket'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new RamadanBasketItemsUpdatedNotification(
                user: $this->user
            )
        );
    }
}
