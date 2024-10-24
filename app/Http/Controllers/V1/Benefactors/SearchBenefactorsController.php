<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\PersonResource;

class SearchBenefactorsController extends Controller
{
    public function __invoke()
    {
        return PersonResource::collection(searchBenefactors());
    }
}
