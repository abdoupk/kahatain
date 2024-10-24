<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\Resources\Json\JsonResource;

class ListCommitteesController extends Controller
{
    public function __invoke()
    {
        return response()->json(
            JsonResource::collection(
                Committee::select(['name', 'id'])->get()
            ));
    }
}
