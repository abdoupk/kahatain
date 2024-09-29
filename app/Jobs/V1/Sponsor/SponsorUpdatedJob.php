<?php

namespace App\Jobs\V1\Sponsor;

use App\Models\Sponsor;
use App\Models\User;
use App\Notifications\Sponsor\UpdateSponsorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class SponsorUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Sponsor $sponsor, public User $user)
    {
    }

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_sponsors'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new UpdateSponsorNotification(
                sponsor: $this->sponsor,
                user: $this->user
            )
        );
    }
}
