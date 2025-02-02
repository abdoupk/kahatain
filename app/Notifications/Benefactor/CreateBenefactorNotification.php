<?php

namespace App\Notifications\Benefactor;

use App\Models\Benefactor;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateBenefactorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Benefactor $benefactor, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->benefactor->getName(),
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
                    'tenant.benefactors.index'
                ).'?show='.$this->benefactor->id,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->benefactor->getName(),
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
        return 'benefactor.created';
    }

    public function broadcastType(): string
    {
        return 'benefactor.created';
    }
}
