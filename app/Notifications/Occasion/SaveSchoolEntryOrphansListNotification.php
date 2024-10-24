<?php

namespace App\Notifications\Occasion;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SaveSchoolEntryOrphansListNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Archive $archive, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'occasion' => $this->archive->occasion,
                'orphans_count' => $this->archive->loadCount('listOrphans')->list_orphans_count,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
            'metadata' => [
                'url' => tenant_route(
                    $this->user->tenant->domains->first()->domain,
                    'tenant.occasions.school-entry.index'
                ),
            ],
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'occasion' => $this->archive->occasion,
                'orphans_count' => $this->archive->loadCount('listOrphans')->list_orphans_count,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->getName(),
                'gender' => $this->user->gender,
            ],
        ]);
    }

    public function databaseType(): string
    {
        return 'school_entry_orphans_list.saved';
    }

    public function broadcastType(): string
    {
        return 'school_entry_orphans_list.saved';
    }
}
