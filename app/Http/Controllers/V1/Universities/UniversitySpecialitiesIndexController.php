<?php

namespace App\Http\Controllers\V1\Universities;

use App\Http\Controllers\Controller;
use App\Models\UniversitySpeciality;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversitySpecialitiesIndexController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(UniversitySpeciality::all()->map(function (UniversitySpeciality $universitySpeciality) {
            return [
                'id' => $universitySpeciality->id,
                'name' => $universitySpeciality->speciality,
            ];
        })
        ));
    }
}
