<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EidSuitInfosUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $ids, public User $user) {}

    public function broadcastWith(): array
    {
        return [
            'ids' => $this->ids,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'orphans_count' => count($this->ids),
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('eid-suit-infos-updated'),
        ];
    }
}
