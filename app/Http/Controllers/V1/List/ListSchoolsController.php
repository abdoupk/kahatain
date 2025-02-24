<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Schools\ListSchoolsResource;
use App\Models\PrivateSchool;

class ListSchoolsController extends Controller
{
    public function __invoke()
    {
        return response()->json(ListSchoolsResource::collection(PrivateSchool::with('subjects.academicLevel')->latest()->get()));
    }
}
