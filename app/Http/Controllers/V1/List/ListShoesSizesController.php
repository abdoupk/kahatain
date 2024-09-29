<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\ShoeSize;
use Illuminate\Http\Resources\Json\JsonResource;

class ListShoesSizesController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(ShoeSize::all()->map(fn ($shoeSize) => [
            'id' => $shoeSize->id,
            'name' => $shoeSize->label,
        ])));
    }
}
