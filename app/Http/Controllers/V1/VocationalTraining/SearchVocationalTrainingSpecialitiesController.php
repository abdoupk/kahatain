<?php

namespace App\Http\Controllers\V1\VocationalTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchVocationalTrainingSpecialitiesController extends Controller
{
    public function __invoke()
    {
        return JsonResource::collection(searchVocationalTrainingSpecialities());
    }
}
