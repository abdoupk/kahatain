<?php

namespace App\Http\Controllers\V1\Schools;

use App\Models\School;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class SchoolsSearchController extends Collection
{
    public function __invoke()
    {
        $phase = request()->phase_key ?? 'primary_education';
        $cityId = request()->city_id ?? tenant('infos')['city_id'];

        return JsonResource::collection(search(School::getModel(),
            additional_filters: "phase_key = $phase AND city_id = ".$cityId.' ',
            limit: 300
        )->get());
    }
}