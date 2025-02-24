<?php

namespace App\Notifications\SiteSettings;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ExportCompleteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private array $metaData;

    public function __construct(public Tenant $tenant)
    {
        $this->metaData = [
            'processed_at' => now(),
            'subject' => 'data_exported',
            'url' => tenant_route(
                $this->tenant->domains->first()
                    ->domain,
                'tenant.site-settings.download-data'
            ),
        ];
    }

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'metadata' => $this->metaData,
            'user' => [
                'id' => '',
                'name' => 'support_team',
                'gender' => 'male',
            ],
            'data' => [],
        ]);
    }

    public function toArray(): array
    {
        return [
            'metadata' => $this->metaData,
            'user' => [
                'id' => '',
                'name' => 'support_team',
                'gender' => 'male',
            ],
            'data' => [],
        ];
    }

    public function databaseType(): string
    {
        return 'data_exported';
    }

    public function broadcastType(): string
    {
        return 'data_exported';
    }
}
