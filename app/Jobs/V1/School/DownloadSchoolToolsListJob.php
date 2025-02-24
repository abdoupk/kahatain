<?php

namespace App\Jobs\V1\School;

use App\Models\User;
use App\Notifications\School\DownloadSchoolToolsListNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class DownloadSchoolToolsListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_students'],
                userToExclude: $this->user,
                notificationType: 'schools_and_lessons_changes'
            ),
            new DownloadSchoolToolsListNotification(
                user: $this->user
            )
        );
    }
}
