<?php

namespace App\Http\Controllers\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Events\EventDetailsResource;
use App\Models\EventOccurrence;
use Illuminate\Routing\Controllers\HasMiddleware;

class LessonShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_lesson'];
    }

    public function __invoke(EventOccurrence $eventOccurrence)
    {
        return response()->json([
            'lesson' => new EventDetailsResource(
                $eventOccurrence->load(
                    'lesson.subject',
                    'lesson.school',
                    'lesson.academicLevel',
                    'orphans.sponsor:id,first_name,last_name,phone_number',
                    'event',
                    'lesson.school.subjects.academicLevel'
                )
            ),
        ]);
    }
}
