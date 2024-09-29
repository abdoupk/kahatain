<?php

namespace App\Notifications\Inventory;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteInventoryItemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Inventory $item, public User $user)
    {
    }

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->item->name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->item->name,
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
        return 'delete_item_from_inventory';
    }

    public function broadcastType(): string
    {
        return 'delete_item_from_inventory';
    }
}
