<?php

namespace App\Jobs\V1\Transcript;

use App\Models\Orphan;
use App\Models\User;
use App\Notifications\Transcript\UpdateTranscriptNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class TranscriptUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Orphan $orphan, public string $trimester, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_transcripts', 'view_transcripts'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new UpdateTranscriptNotification(
                orphan: $this->orphan,
                trimester: $this->trimester,
                user: $this->user
            )
        );
    }
}
