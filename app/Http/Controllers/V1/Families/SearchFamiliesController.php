<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\PersonResource;

class SearchFamiliesController extends Controller
{
    public function __invoke()
    {
        return PersonResource::collection(searchFamilies());
    }
}
