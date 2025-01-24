<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Orphan;
use App\Models\User;
use App\Notifications\Occasion\EidSuitOrphanUpdateInfosNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class EidSuitOrphanUpdateInfosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Orphan $orphan, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new EidSuitOrphanUpdateInfosNotification(
                orphan: $this->orphan,
                user: $this->user
            )
        );
    }
}
