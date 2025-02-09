<?php

namespace App\Http\Controllers\V1\VocationalTraining;

use App\Http\Controllers\Controller;
use App\Models\VocationalTrainingCenter;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchVocationalTrainingCentersController extends Controller
{
    public function __invoke()
    {
        return JsonResource::collection(VocationalTrainingCenter::search(request()->string('search'), function ($meilisearch, string $query, array $options) {
            $options['filter'] = 'wilaya_code = '.tenant('infos')['city']['wilaya_code'].' ';

            return $meilisearch->search($query, $options);
        })->get()->map(fn(VocationalTrainingCenter $vocationalTrainingCenter) => [
            'id' => $vocationalTrainingCenter->id,
            'name' => $vocationalTrainingCenter->getName(),
        ]));
    }
}
