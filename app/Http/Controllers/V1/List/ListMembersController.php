<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\PersonResource;
use App\Models\User;

class ListMembersController extends Controller
{
    public function __invoke()
    {
        return response()->json(PersonResource::collection(User::select(['id', 'first_name', 'last_name'])->get()));
    }
}
