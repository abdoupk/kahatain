<?php

namespace App\Jobs\V1\SiteSettings;

use App\Models\User;
use App\Notifications\Occasion\MonthlySponsorshipSettingsUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class MonthlySponsorshipSettingsUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        $this->user->load('tenant.families')->tenant->families->each(function ($family): void {
            monthlySponsorship($family);
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['update_settings_monthly_sponsorships'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new MonthlySponsorshipSettingsUpdatedNotification(
                user: $this->user
            )
        );
    }
}
