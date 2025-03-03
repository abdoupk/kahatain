<?php

namespace App\Notifications\Need;

use App\Models\Need;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateNeedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Need $need, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'subject' => $this->need->subject,
                'needable_type' => $this->need->needable_type,
                'name' => $this->need->needable?->getName(),
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'processed_at' => now(),
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.needs.index'
                ).'?show='.$this->need->id,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'subject' => $this->need->subject,
                'needable_type' => $this->need->needable_type,
                'name' => $this->need->needable?->getName(),
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
        return 'need.created';
    }

    public function broadcastType(): string
    {
        return 'need.created';
    }
}
