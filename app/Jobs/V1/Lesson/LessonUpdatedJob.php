<?php

namespace App\Jobs\V1\Lesson;

use App\Models\Event;
use App\Models\User;
use App\Notifications\Lesson\UpdateLessonNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class LessonUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Event $event, public User $user)
    {
    }

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_lessons', 'view_lessons'],
                userToExclude: $this->user,
                notificationType: 'schools_and_lessons_changes'
            ),
            new UpdateLessonNotification(
                event: $this->event,
                user: $this->user
            )
        );
    }
}
