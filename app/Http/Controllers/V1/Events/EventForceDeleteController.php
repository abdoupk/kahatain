<?php

namespace App\Http\Controllers\V1\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class EventForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:destroy_trash'];
    }

    public function __invoke(Event $event): Response
    {
        $event->forceDelete();

        return response('', 204);
    }
}
