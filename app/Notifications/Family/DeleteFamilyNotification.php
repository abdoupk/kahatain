<?php

namespace App\Notifications\Family;

use App\Models\Family;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteFamilyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Family $family, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->family->name,
                'zone' => $this->family->zone?->name,
                'branch' => $this->family->branch?->name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'deleted_at' => $this->family->deleted_at,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->family->name,
                'zone' => $this->family->zone?->name,
                'branch' => $this->family->branch?->name,
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
        return 'family.deleted';
    }

    public function broadcastType(): string
    {
        return 'family.deleted';
    }
}
