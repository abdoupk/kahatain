<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitySearchResource;
use App\Models\City;

class CitySearchController extends Controller
{
    public function __invoke()
    {
        return CitySearchResource::collection(City::search(request()->string('search'))->get());
    }
}
