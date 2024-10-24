<?php

namespace App\Notifications\Finance;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteFinanceTransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Finance $finance, public User $user) {}

    public function via(): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'type' => $this->finance->amount > 0 ? 'income' : 'expense',
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
                'type' => $this->finance->amount > 0 ? 'income' : 'expense',
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
        return 'finance.deleted';
    }

    public function broadcastType(): string
    {
        return 'finance.deleted';
    }
}
