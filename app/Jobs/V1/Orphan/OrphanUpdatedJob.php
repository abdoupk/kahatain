<?php

namespace App\Jobs\V1\Orphan;

use App\Models\Orphan;
use App\Models\User;
use App\Notifications\Orphan\UpdateOrphanNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class OrphanUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Orphan $orphan, public User $user)
    {
    }

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_orphans'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new UpdateOrphanNotification(
                orphan: $this->orphan,
                user: $this->user
            )
        );
    }
}
