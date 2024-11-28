<?php

namespace App\Jobs\V1\Transcript;

use App\Models\Transcript;
use App\Models\User;
use App\Notifications\Transcript\CreateTranscriptNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class TranscriptCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Transcript $transcript, public User $user) {}

    public function handle(): void
    {
        $this->transcript->orphan()->searchable();

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_transcripts', 'view_transcripts'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new CreateTranscriptNotification(
                transcript: $this->transcript,
                user: $this->user
            )
        );
    }
}
