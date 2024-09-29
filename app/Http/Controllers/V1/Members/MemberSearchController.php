<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Members\MemberResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MemberSearchController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return MemberResource::collection(searchMembers());
    }
}
