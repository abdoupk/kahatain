<?php

namespace App\Http\Controllers\V1\AcademicLevel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicLevelIndexController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(formatedAcademicLevels()));
    }
}
