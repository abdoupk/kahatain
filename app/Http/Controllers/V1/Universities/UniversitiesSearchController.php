<?php

namespace App\Http\Controllers\V1\Universities;

use App\Http\Controllers\Controller;
use App\Models\University;

class UniversitiesSearchController extends Controller
{
    public function __invoke()
    {
        return University::search(request()->string('search'), function ($meilisearch, string $query, array $options) {
            $options['limit'] = 30;

            return $meilisearch->search($query, $options);
        })
            ->get()->map(fn (University $university) => [
                'id' => $university->id,
                'name' => $university->name,
            ]);
    }
}
