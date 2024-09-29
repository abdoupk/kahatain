<?php

namespace App\Http\Controllers\V1\Notifications;

use App\Http\Controllers\Controller;

class NotificationMarkAsReadController extends Controller
{
    public function __invoke(string $id): void
    {
        auth()->user()?->notifications()->where('id', $id)->update(['read_at' => now()]);
    }
}
