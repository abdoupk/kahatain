<?php

namespace App\Notifications\Family;

use App\Models\Family;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateFamilyNotification extends Notification implements ShouldQueue
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
                'name' => $this->family->getName(),
                'zone' => $this->family->zone?->name,
                'branch' => $this->family->branch?->name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'processed_at' => $this->family->created_at,
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.families.show',
                    $this->family->id
                ),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->family->getName(),
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
        return 'family.created';
    }

    public function broadcastType(): string
    {
        return 'family.created';
    }
}
