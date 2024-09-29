<?php

namespace App\Http\Controllers\V1\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NotificationResource;
use Illuminate\Http\Request;

class NotificationsIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->wantsJson()) {
            return NotificationResource::collection(auth()->user()?->notifications()->cursorPaginate(10));
        }

        return response()->json([
            'notifications' => auth()->user()?->notifications()->cursorPaginate(10),
        ]);
    }
}
