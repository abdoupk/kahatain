<?php

namespace App\Notifications\Benefactor;

use App\Models\Benefactor;
use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateBenefactorSponsorshipNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Benefactor $benefactor, public Sponsorship $sponsorship, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->benefactor->getName(),
                'recipientable_name' => $this->sponsorship->recipientable?->getName(),
                'sponsorship_type' => $this->sponsorship->sponsorship_type,
                'recipientable_type' => $this->sponsorship->recipientable_type,
                'amount' => $this->sponsorship->amount,
                'until' => $this->sponsorship->until?->translatedFormat('j'.__('glue').'F Y'),
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
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
                'recipientable_name' => $this->sponsorship->recipientable?->getName(),
                'sponsorship_type' => $this->sponsorship->sponsorship_type,
                'recipientable_type' => $this->sponsorship->recipientable_type,
                'amount' => $this->sponsorship->amount,
                'until' => $this->sponsorship->until?->translatedFormat('j'.__('glue').'F Y'),
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
        return 'benefactor.sponsorship_created';
    }

    public function broadcastType(): string
    {
        return 'benefactor.sponsorship_created';
    }
}
