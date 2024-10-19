<?php

namespace App\Notifications\Inventory;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateInventoryItemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Inventory $item, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->item->name,
                'qty' => $this->item->qty,
                'unit' => $this->item->unit,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.inventory.index'
                ).'?show='.$this->item->id,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->item->name,
                'qty' => $this->item->qty,
                'unit' => $this->item->unit,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
        ]);
    }

    public function databaseType(): string
    {
        return 'add_item_to_inventory';
    }

    public function broadcastType(): string
    {
        return 'add_item_to_inventory';
    }
}
