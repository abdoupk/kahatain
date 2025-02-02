<?php

namespace App\Notifications\Occasion;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SaveRamadanBasketFamiliesListNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Archive $archive, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'occasion' => $this->archive->occasion,
                'families_count' => $this->archive->loadCount('listFamilies')->list_families_count,
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
                    'tenant.occasions.ramadan-basket.index'
                ),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'occasion' => $this->archive->occasion,
                'families_count' => $this->archive->loadCount('listFamilies')->list_families_count,
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
        return 'ramadan_basket_families_list.saved';
    }

    public function broadcastType(): string
    {
        return 'ramadan_basket_families_list.saved';
    }
}
