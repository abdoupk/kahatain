<?php

namespace App\Jobs\V1\Finance;

use App\Models\Finance;
use App\Models\User;
use App\Notifications\Finance\UpdateFinanceTransactionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class FinanceUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Finance $finance, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_financial_transactions', 'view_financial_transactions'],
                userToExclude: $this->user,
                notificationType: 'financial_changes'
            ),
            new UpdateFinanceTransactionNotification(
                finance: $this->finance,
                user: $this->user
            )
        );
    }
}
