<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Family;
use App\Models\User;
use App\Notifications\Occasion\EidAlAdhaFamiliesStatusUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class EidAlAdhaFamiliesStatusUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Family $family, public string $status, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new EidAlAdhaFamiliesStatusUpdatedNotification(
                family: $this->family,
                status: $this->status,
                user: $this->user
            )
        );
    }
}
