<?php

namespace App\Jobs\V1\Family;

use App\Models\Family;
use App\Models\User;
use App\Notifications\Family\DeleteFamilyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class FamilyTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Family $family, public User $user, public string $reason)
    {
    }

    public function handle(): void
    {
        $this->family->unSearchWithRelations();

        $this->family->deleteWithRelationships($this->user->id, $this->reason);

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new DeleteFamilyNotification(
                family: $this->family,
                user: $this->user
            )
        );
    }
}
