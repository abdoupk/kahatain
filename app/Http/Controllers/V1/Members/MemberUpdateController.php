<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Members\MemberUpdateRequest;
use App\Jobs\V1\Member\MemberUpdatedJob;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberUpdateController extends Controller implements HasMiddleware
{
    public function __invoke(
        MemberUpdateRequest $request,
        User $member
    ): Response {
        $member->update($request->except(['roles', 'formatted_roles', 'zone', 'branch', 'id']));

        $member->syncRoles($request->roles);

        dispatch(new MemberUpdatedJob($member, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_members'];
    }
}
