<?php

namespace App\Jobs\V1\Inventory;

use App\Models\Inventory;
use App\Models\User;
use App\Notifications\Inventory\CreateInventoryItemNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class InventoryItemCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Inventory $item, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_items', 'view_item'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new CreateInventoryItemNotification(
                item: $this->item,
                user: $this->user
            )
        );
    }
}
