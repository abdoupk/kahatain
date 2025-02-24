<?php

namespace App\Jobs\V1\Committee;

use App\Models\Committee;
use App\Models\User;
use App\Notifications\Committee\DeleteCommitteeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class CommitteeTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Committee $committee, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_committees', 'view_committees'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new DeleteCommitteeNotification(
                committee: $this->committee,
                user: $this->user
            )
        );
    }
}
