<?php

namespace App\Jobs\V1\Zone;

use App\Models\User;
use App\Models\Zone;
use App\Notifications\Zone\CreateZoneNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class ZoneCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Zone $zone, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_zones', 'view_zones'],
                userToExclude: $this->user,
                notificationType: 'branches_and_zones_changes'
            ),
            new CreateZoneNotification(
                zone: $this->zone,
                user: $this->user
            )
        );
    }
}
