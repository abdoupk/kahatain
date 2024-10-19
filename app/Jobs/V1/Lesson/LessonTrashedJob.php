<?php

namespace App\Jobs\V1\Lesson;

use App\Models\EventOccurrence;
use App\Models\User;
use App\Notifications\Lesson\DeleteLessonNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class LessonTrashedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public EventOccurrence $eventOccurrence, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_trash'],
                userToExclude: $this->user,
                notificationType: 'schools_and_lessons_changes'
            ),
            new DeleteLessonNotification(
                eventOccurrence: $this->eventOccurrence,
                user: $this->user
            )
        );
    }
}
