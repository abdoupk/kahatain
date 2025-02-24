<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lessons\OrphansResource;
use App\Models\Orphan;

class ListOrphansController extends Controller
{
    public function __invoke()
    {
        return OrphansResource::collection(Orphan::whereAcademicLevelId(request()->input('academic_level_id'))->select(['id', 'first_name', 'last_name'])->get());
    }
}
