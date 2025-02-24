<?php

namespace App\Http\Controllers\V1\Universities;

use App\Http\Controllers\Controller;
use App\Models\UniversitySpeciality;

class UniversitySpecialitiesSearchController extends Controller
{
    public function __invoke()
    {
        return UniversitySpeciality::search(request()->string('search'), function ($meilisearch, string $query, array $options) {
            $options['limit'] = 30;

            return $meilisearch->search($query, $options);
        })
            ->get()->map(fn (UniversitySpeciality $universitySpeciality) => [
                'id' => $universitySpeciality->id,
                'name' => $universitySpeciality->getName(),
            ]);
    }
}
