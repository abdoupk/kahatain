<?php

namespace App\Http\Controllers\V1\VocationalTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class VocationalTrainingIndexController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(formatedVocationalTrainingSpecialities()));
    }
}
