<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Lessons\LessonUpdateDatesRequest;
use App\Models\EventOccurrence;
use Illuminate\Routing\Controllers\HasMiddleware;

class LessonUpdateDatesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_lessons'];
    }

    public function __invoke(LessonUpdateDatesRequest $request, EventOccurrence $lesson): void
    {
        $lesson->update($request->validated());
    }
}
