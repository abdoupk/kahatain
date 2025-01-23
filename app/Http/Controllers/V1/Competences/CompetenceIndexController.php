<?php

namespace App\Http\Controllers\V1\Competences;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetenceIndexController extends Controller
{
    public function __invoke()
    {
        return response()->json(
            JsonResource::collection(
                Competence::select(['name', 'id'])->get()
            ));
    }
}
