<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Benefactor;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBenefactorsController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(
            Benefactor::select(['id', 'first_name', 'last_name'])
                ->get()->map(fn (Benefactor $benefactor) => [
                    'id' => $benefactor->id,
                    'name' => $benefactor->getName(),
                ])));
    }
}
