<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Members\MemberUpdateResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_members'];
    }

    public function __invoke(User $member): JsonResponse
    {
        return response()->json([
            'member' => MemberUpdateResource::make($member->load(['zone', 'branch', 'roles.permissions', 'competences:id,name', 'committees:id,name'])),
        ]);
    }
}
