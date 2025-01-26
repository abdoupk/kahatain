<?php

namespace App\Jobs\V1\Family;

use App\Models\Family;
use App\Models\User;
use App\Notifications\Family\CreateFamilyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class FamilyCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Family $family, public User $user) {}

    public function handle(): void
    {
        $this->family->update([
            'total_income' => calculateTotalIncomes($this->family),
            'income_rate' => calculateIncomeRate($this->family, json_decode($this->family->load('tenant')->tenant['calculation'], true)),
        ]);

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_families'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new CreateFamilyNotification(
                family: $this->family,
                user: $this->user
            )
        );
    }
}
