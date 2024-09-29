<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBabyMilkController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(
            Inventory::where('type', 'baby_milk')
                ->select(['id', 'name'])
                ->get()
        ));
    }
}
