<?php

namespace App\Notifications\Transcript;

use App\Models\Orphan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CreateTranscriptNotification extends Notification implements ShouldQueue
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
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.students.phase.index',
                    [
                        'academicLevel' => $this->orphan->academic_level_id,
                        'phase' => str_replace('_', '-', $this->orphan->academicLevel->phase_key),
                    ]
                ),
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
        return 'transcript.created';
    }

    public function broadcastType(): string
    {
        return 'transcript.created';
    }
}
