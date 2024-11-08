<?php

namespace App\Jobs\V1\SiteSettings;

use App\Models\Family;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MonthlySponsorshipSettingsUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function handle(): void
    {
        $this->user->load('tenant.families')->tenant->families->each(function (Family $family) {
            monthlySponsorship($family);
        });
    }
}
