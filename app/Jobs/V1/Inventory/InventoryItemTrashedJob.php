<?php

namespace App\Jobs\V1\Inventory;

use App\Models\Inventory;
use App\Models\MonthlyBasket;
use App\Models\RamadanBasket;
use App\Models\User;
use App\Notifications\Inventory\DeleteInventoryItemNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class InventoryItemTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Inventory $item, public User $user) {}

    public function handle(): void
    {
        MonthlyBasket::where('inventory_id', $this->item->id)->forceDelete();

        RamadanBasket::where('inventory_id', $this->item->id)->forceDelete();

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new DeleteInventoryItemNotification(
                item: $this->item,
                user: $this->user
            )
        );
    }
}
