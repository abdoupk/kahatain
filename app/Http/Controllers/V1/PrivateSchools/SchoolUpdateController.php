<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Schools\SchoolUpdateRequest;
use App\Jobs\V1\School\SchoolUpdatedJob;
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
        $school->update($request->only('name'));

        $school->lessons()->forceDelete();

        collect($request->lessons)->each(function ($lesson) use ($school): void {
            $school->lessons()->create($lesson);
        });

        dispatch(new SchoolUpdatedJob($school, auth()->user()));

        return response('', 201);
    }
}
