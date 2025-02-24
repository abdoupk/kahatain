<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Lessons\LessonUpdateRequest;
use App\Jobs\V1\Lesson\LessonUpdatedJob;
use App\Models\EventOccurrence;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Recurr\Exception\InvalidArgument;
use Recurr\Exception\InvalidWeekday;

class LessonUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_lessons'];
    }

    /**
     * @throws InvalidWeekday
     * @throws InvalidArgument
     */
    public function __invoke(LessonUpdateRequest $request, EventOccurrence $eventOccurrence): void
    {
        if (! $request->update_this_and_all_coming) {
            $eventOccurrence->update([
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->end_date),
            ]);
        } else {
            $eventOccurrence->orphans()->detach();

            $eventOccurrence->orphans()->attach($request->orphans, ['lesson_id' => $eventOccurrence->lesson_id]);

            $eventOccurrence->event()->update([
                ...$request->only(['color', 'until', 'frequency', 'title', 'interval']),
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->end_date),
            ]);

            $eventOccurrence->event->occurrences()->where('start_date', '>=', $eventOccurrence->start_date)->delete();

            generateOccurrences($eventOccurrence->event, $eventOccurrence->lesson_id, $request->orphans);

            dispatch(new LessonUpdatedJob($eventOccurrence->event, auth()->user()));
        }
    }
}
