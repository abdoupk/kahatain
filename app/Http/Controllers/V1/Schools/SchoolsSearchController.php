<?php

namespace App\Http\Controllers\V1\Schools;

use App\Models\School;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class SchoolsSearchController extends Collection
{
    public function __invoke()
    {
        return JsonResource::collection(search(School::getModel(),
            additional_filters: 'phase_key = middle_school AND city_id = 1144 ',
            limit: 100
        )->get());
    }
}
