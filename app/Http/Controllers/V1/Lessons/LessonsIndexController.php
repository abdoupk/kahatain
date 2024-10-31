<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lessons\SchoolsResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class LessonsIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_lessons'];
    }

    public function __invoke()
    {
        return Inertia::render('Tenant/lessons/index/LessonsIndexPage', [
            'schools' => SchoolsResource::collection(getSchoolsForAddLesson()),
            'events' => getLessons(),
        ]);
    }
}
