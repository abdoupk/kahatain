<?php

namespace App\Jobs\V1\Sponsor;

use App\Models\Sponsor;
use App\Models\User;
use App\Notifications\Sponsor\DeleteSponsorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class SponsorTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Sponsor $sponsor, public User $user)
    {
    }

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'familias_changes'
            ),
            new DeleteSponsorNotification(
                sponsor: $this->sponsor,
                user: $this->user
            )
        );
    }
}
