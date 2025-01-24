<?php

namespace App\Jobs\V1\Occasion;

use App\Models\User;
use App\Notifications\Occasion\EidSuitBulkUpdateInfosNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class EidSuitBulkUpdateInfosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $orphans, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new EidSuitBulkUpdateInfosNotification(
                orphans: $this->orphans,
                user: $this->user
            )
        );
    }
}
