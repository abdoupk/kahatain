<?php

namespace App\Http\Controllers\V1\Schools;

use App\Http\Resources\V1\Schools\SearchSchoolsResource;
use App\Models\School;
use Illuminate\Support\Collection;

class SchoolsSearchController extends Collection
{
    public function __invoke()
    {
        $phase = request()->phase_key ?? 'primary_education';
        $wilayaCode = tenant('infos')['city']['wilaya_code'] ?? null;

        return SearchSchoolsResource::collection(search(School::getModel(),
            additional_filters: "phase_key = $phase AND city.wilaya_code = ".$wilayaCode.' ',
            limit: 300
        )->query(fn ($query) => $query->with('city'))->get());
    }
}
