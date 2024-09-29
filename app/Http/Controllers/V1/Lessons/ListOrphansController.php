<?php

namespace App\Http\Controllers\V1\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lessons\OrphansResource;

class ListOrphansController extends Controller
{
    public function __invoke()
    {
        return OrphansResource::collection(getOrphansForAddLesson());
    }
}
