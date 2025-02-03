<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Family;
use App\Models\User;
use App\Notifications\Occasion\RamadanSponsorshipSettingsUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class RamadanSponsorshipSettingsUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        $this->user->load('tenant.families')->tenant->families->each(function (Family $family) {
            monthlySponsorship($family);
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['update_settings_monthly_sponsorships'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new RamadanSponsorshipSettingsUpdatedNotification(
                user: $this->user
            )
        );
    }
}
