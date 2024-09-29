<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Models\EventOccurrence;
use Illuminate\Routing\Controllers\HasMiddleware;

class LessonDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(EventOccurrence $lesson)
    {
        $lesson->delete();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:delete_lessons'];
    }
}
