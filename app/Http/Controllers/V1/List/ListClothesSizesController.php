<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\ClothesSize;
use Illuminate\Http\Resources\Json\JsonResource;

class ListClothesSizesController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(ClothesSize::all()->map(fn ($clothesSize) => [
            'id' => $clothesSize->label,
            'name' => $clothesSize->label,
        ])));
    }
}
