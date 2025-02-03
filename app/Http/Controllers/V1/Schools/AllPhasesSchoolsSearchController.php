<?php

namespace App\Http\Controllers\V1\Schools;

use App\Http\Controllers\Controller;
use App\Models\School;

class AllPhasesSchoolsSearchController extends Controller
{
    public function __invoke()
    {
        $wilayaCode = tenant('infos')['city']['wilaya_code'] ?? null;

        return School::search(
            request()->string('search'),
            static function (
                $meilisearch,
                string $query,
                array $options
            ) use ($wilayaCode) {
                $options['filter'] = 'phase_key IN [primary_education, middle_education, secondary_education] AND city.wilaya_code = '.$wilayaCode.' ';

                $options['limit'] = 30;

                return $meilisearch->search($query, $options);
            }
        )->get()->map(fn ($school) => [
            'id' => $school->id,
            'name' => $school->name,
        ]);
    }
}
