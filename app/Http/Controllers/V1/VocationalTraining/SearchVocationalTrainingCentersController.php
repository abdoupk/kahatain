<?php

namespace App\Http\Controllers\V1\VocationalTraining;

use App\Http\Controllers\Controller;
use App\Models\VocationalTrainingCenter;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchVocationalTrainingCentersController extends Controller
{
    public function __invoke()
    {
        return JsonResource::collection(search(VocationalTrainingCenter::getModel(),
            limit: 25)->get()->map(function (VocationalTrainingCenter $vocationalTrainingCenter) {
                return [
                    'id' => $vocationalTrainingCenter->id,
                    'name' => $vocationalTrainingCenter->getName(),
                ];
            }));
    }
}
