<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Lessons\LessonCreateRequest;
use App\Jobs\V1\Lesson\LessonCreatedJob;
use App\Models\Event;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Recurr\Exception\InvalidArgument;
use Recurr\Exception\InvalidWeekday;

class LessonStoreController extends Controller implements HasMiddleware
{
    /**
     * @throws InvalidWeekday
     * @throws InvalidArgument
     */
    public function __invoke(LessonCreateRequest $request): void
    {
        $lesson = Lesson::where('subject_id', $request->subject_id)
            ->where('private_school_id', $request->school_id)
            ->where('academic_level_id', $request->academic_level_id)
            ->first();

        $event = Event::create([
            ...$request->except(['orphans', 'subject_id', 'academic_level_id', 'school_id', 'start_date', 'end_date']),
            'lesson_id' => $lesson->id,
            'start_date' => Carbon::parse($request->start_date)->addHour(),
            'end_date' => Carbon::parse($request->start_date)->addHour(),
        ]);

        dispatch(new LessonCreatedJob($event, auth()->user()));

        generateOccurrences($event, $lesson->id, $request->orphans);
    }

    public static function middleware()
    {
        return ['can:create_lessons'];
    }
}
