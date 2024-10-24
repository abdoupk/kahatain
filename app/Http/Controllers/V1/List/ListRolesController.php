<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class ListRolesController extends Controller
{
    public function __invoke()
    {
        return response()->json(JsonResource::collection(
            Role::select(['uuid', 'name'])
                ->where('name', '!=', 'super_admin')
                ->get())
        );
    }
}
