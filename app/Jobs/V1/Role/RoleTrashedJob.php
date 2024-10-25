<?php

namespace App\Jobs\V1\Role;

use App\Models\Role;
use App\Models\User;
use App\Notifications\Role\DeleteRoleNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class RoleTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Role $role, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new DeleteRoleNotification(
                role: $this->role,
                user: $this->user
            )
        );
    }
}
