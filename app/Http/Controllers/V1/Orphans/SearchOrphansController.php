<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\PersonResource;

class SearchOrphansController extends Controller
{
    public function __invoke()
    {
        return PersonResource::collection(searchOrphans());
    }
}
