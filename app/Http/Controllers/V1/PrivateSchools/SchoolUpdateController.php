<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Schools\SchoolUpdateRequest;
use App\Jobs\V1\School\SchoolUpdatedJob;
use App\Models\Lesson;
use App\Models\PrivateSchool;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_schools'];
    }

    public function __invoke(SchoolUpdateRequest $request, PrivateSchool $school)
    {
        Lesson::whereIn('id', $request->deleted_lessons)->forceDelete();

        $school->update($request->only('name'));

        $lessonsToCreate = collect($request->lessons)
            ->map(fn ($lesson) => [
                'id' => $lesson['id'],
                'quota' => $lesson['quota'],
                'subject_id' => $lesson['subject_id'],
                'start_date' => $lesson['start_date'],
                'end_date' => $lesson['end_date'],
                'academic_level_id' => $lesson['academic_level_id'],
                'private_school_id' => $school->id,
                'tenant_id' => $school->tenant_id,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        Lesson::upsert(
            $lessonsToCreate,
            ['id'],
            ['quota', 'subject_id', 'start_date', 'end_date', 'private_school_id', 'tenant_id', 'academic_level_id']
        );

        dispatch(new SchoolUpdatedJob($school, auth()->user()));

        return response('', 201);
    }
}
