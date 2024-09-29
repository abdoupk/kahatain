<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;

class ListSubjectsController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(Subject::all()->map(fn ($subject) => [
            'id' => $subject->id,
            'name' => $subject->getName(),
        ])));
    }
}
