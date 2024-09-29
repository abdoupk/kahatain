<?php

namespace App\Jobs\V1\Need;

use App\Models\Need;
use App\Models\User;
use App\Notifications\Need\CreateNeedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class NeedCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Need $need, public User $user)
    {
    }

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_needs', 'view_needs'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new CreateNeedNotification(
                need: $this->need,
                user: $this->user
            )
        );
    }
}
