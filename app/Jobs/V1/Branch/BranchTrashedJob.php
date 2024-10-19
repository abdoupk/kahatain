<?php

namespace App\Jobs\V1\Branch;

use App\Models\Branch;
use App\Models\User;
use App\Notifications\Branch\DeleteBranchNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class BranchTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Branch $branch, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'branches_and_zones_changes'
            ),
            new DeleteBranchNotification(
                branch: $this->branch,
                user: $this->user
            )
        );
    }
}
