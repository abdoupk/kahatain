<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Members\MemberDetailsResource;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberDetailsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_members'];
    }

    public function __invoke(User $member)
    {
        return response()->json([
            'member' => MemberDetailsResource::make($member->load(['zone:id,name', 'creator:id,first_name,last_name', 'branch:id,name', 'competences:id,name', 'committees:id,name'])),
        ]);
    }
}
