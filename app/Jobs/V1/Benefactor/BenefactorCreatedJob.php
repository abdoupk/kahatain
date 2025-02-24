<?php

namespace App\Jobs\V1\Benefactor;

use App\Models\Benefactor;
use App\Models\User;
use App\Notifications\Benefactor\CreateBenefactorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class BenefactorCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Benefactor $benefactor, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_benefactors', 'view_benefactors'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new CreateBenefactorNotification(
                benefactor: $this->benefactor,
                user: $this->user
            )
        );
    }
}
