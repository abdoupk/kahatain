<?php

namespace App\Jobs\V1\Benefactor;

use App\Models\Benefactor;
use App\Models\User;
use App\Notifications\Benefactor\DeleteBenefactorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class BenefactorTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Benefactor $benefactor, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new DeleteBenefactorNotification(
                benefactor: $this->benefactor,
                user: $this->user
            )
        );
    }
}
