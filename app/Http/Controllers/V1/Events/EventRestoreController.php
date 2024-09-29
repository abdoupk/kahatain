<?php

namespace App\Http\Controllers\V1\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Routing\Controllers\HasMiddleware;

class EventRestoreController extends Controller implements HasMiddleware
{
    public function __invoke(Event $event)
    {
        $event->restore();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:restore_trash'];
    }
}
