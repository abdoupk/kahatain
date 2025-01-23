<?php

namespace App\Notifications\Branch;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UpdateBranchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Branch $branch, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->branch?->name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'updated_at' => $this->branch->updated_at,
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.branches.index'
                ).'?show='.$this->branch?->id,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->branch?->name,
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
        return 'branch.updated';
    }

    public function broadcastType(): string
    {
        return 'branch.updated';
    }
}
