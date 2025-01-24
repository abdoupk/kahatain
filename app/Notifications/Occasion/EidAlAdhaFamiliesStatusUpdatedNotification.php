<?php

namespace App\Notifications\Occasion;

use App\Models\Family;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class EidAlAdhaFamiliesStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Family $family, public string $status, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'family' => $this->family->getName(),
                'status' => $this->status,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.occasions.eid-al-adha.index'
                ),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'family' => $this->family->getName(),
                'status' => $this->status,
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
        return 'eid_al_adha_family_status_changed';
    }

    public function broadcastType(): string
    {
        return 'eid_al_adha_family_status_changed';
    }
}
