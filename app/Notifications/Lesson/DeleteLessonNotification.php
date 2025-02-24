<?php

namespace App\Notifications\Lesson;

use App\Models\EventOccurrence;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteLessonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public EventOccurrence $eventOccurrence, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'title' => $this->eventOccurrence->event->title,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'title' => $this->eventOccurrence->event->title,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'processed_at' => now(),
            ],
        ]);
    }

    public function databaseType(): string
    {
        return 'lesson.deleted';
    }

    public function broadcastType(): string
    {
        return 'lesson.deleted';
    }
}
