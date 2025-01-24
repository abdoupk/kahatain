<?php

namespace App\Notifications\School;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DownloadSchoolToolsListNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.students.index'
                ),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
        ]);
    }

    public function databaseType(): string
    {
        return 'school_tools_list_downloaded';
    }

    public function broadcastType(): string
    {
        return 'school_tools_list_downloaded';
    }
}
