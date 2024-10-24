<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Archive;
use App\Models\User;
use App\Notifications\Occasion\SaveMonthlyBasketFamiliesListNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class MonthlyBasketFamiliesListSavedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Archive $archive, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new SaveMonthlyBasketFamiliesListNotification(
                archive: $this->archive,
                user: $this->user
            )
        );
    }
}
