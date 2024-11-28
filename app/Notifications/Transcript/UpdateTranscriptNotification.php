<?php

namespace App\Notifications\Transcript;

use App\Models\Transcript;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UpdateTranscriptNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Transcript $transcript, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'name' => $this->transcript->trimester,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'updated_at' => $this->transcript->updated_at,
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.transcripts.index'
                ).'?show='.$this->transcript->id,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'name' => $this->transcript->trimester,
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
        return 'transcript.updated';
    }

    public function broadcastType(): string
    {
        return 'transcript.updated';
    }
}
