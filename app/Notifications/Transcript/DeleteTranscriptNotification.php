<?php

namespace App\Notifications\Transcript;

use App\Models\Orphan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteTranscriptNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Orphan $orphan, public string $trimester, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'trimester' => __($this->trimester),
                'orphan' => $this->orphan->getName(),
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'processed_at' => now(),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'trimester' => __($this->trimester),
                'orphan' => $this->orphan->getName(),
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
        return 'transcript.deleted';
    }

    public function broadcastType(): string
    {
        return 'transcript.deleted';
    }
}
