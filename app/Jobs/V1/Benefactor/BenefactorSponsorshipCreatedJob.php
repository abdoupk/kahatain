<?php

namespace App\Jobs\V1\Benefactor;

use App\Models\Benefactor;
use App\Models\Sponsorship;
use App\Models\User;
use App\Notifications\Benefactor\CreateBenefactorSponsorshipNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class BenefactorSponsorshipCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Benefactor $benefactor, public Sponsorship $sponsorship, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_benefactors', 'view_benefactors'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new CreateBenefactorSponsorshipNotification(
                benefactor: $this->benefactor,
                sponsorship: $this->sponsorship,
                user: $this->user
            )
        );
    }
}
