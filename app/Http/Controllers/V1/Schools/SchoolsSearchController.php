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

        return SearchSchoolsResource::collection(
            School::search(
                request()->string('search'),
                static function (
                    $meilisearch,
                    string $query,
                    array $options
                ) use ($phase, $wilayaCode) {
                    $options['filter'] = "phase_key = $phase AND city.wilaya_code = ".$wilayaCode.' ';

                    $options['limit'] = 30;

                    return $meilisearch->search($query, $options);
                }
            )->query(fn ($query) => $query->with('city'))->get()
        );
    }
}
