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
    public static function middleware()
    {
        return ['can:update_members'];
    }

    public function __invoke(
        MemberUpdateRequest $request,
        User $member
    ): Response {
        $member->update($request->except(['roles', 'formatted_roles', 'zone', 'branch', 'id', 'committees', 'competences']));

        $member->syncRoles($request->roles);

        syncCompetences($request->competences, $member);

        syncCommittees($request->committees, $member);

        dispatch(new MemberUpdatedJob($member, auth()->user()));

        return response('', 201);
    }
}
