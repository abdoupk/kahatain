<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Family;
use App\Models\User;
use App\Notifications\Occasion\EidSuitOrphansResetInfosNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class EidSuitOrphansResetInfosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        $this->user->load('tenant')->tenant->families()->each(function (Family $family) {
            $family->load('orphans')->orphans->searchable();
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new EidSuitOrphansResetInfosNotification(
                user: $this->user
            )
        );
    }
}
