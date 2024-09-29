<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Events\EventDetailsResource;
use App\Models\EventOccurrence;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class LessonDetailsController extends Controller implements HasMiddleware
{
    public function __invoke(EventOccurrence $eventOccurrence): Response
    {
        return Inertia::render(
            'Tenant/lessons/details/LessonDetailPage',
            [
                'lesson' => new EventDetailsResource(
                    $eventOccurrence->load(
                        'lesson.subject',
                        'lesson.school',
                        'lesson.academicLevel',
                        'orphans',
                        'event'
                    )
                ),
            ]
        );
    }
    public static function middleware()
    {
        return ['can:view_lessons'];
    }
}
