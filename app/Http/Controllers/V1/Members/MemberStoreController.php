<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Members\MemberCreateRequest;
use App\Jobs\V1\Member\MemberCreatedJob;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberStoreController extends Controller implements HasMiddleware
{
    public function __invoke(MemberCreateRequest $request): Response
    {
        $user = User::create(
            [
                ...$request->only(
                    [
                        'password', 'email', 'last_name', 'first_name', 'phone',
                        'zone_id', 'branch_id', 'qualification', 'gender',
                    ]
                ),
                'created_by' => auth()->id(),
            ],

        );

        $user->syncRoles($request->roles);

        $user->searchable();

        $user->roles()->searchable();

        dispatch(new MemberCreatedJob($user, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:create_members'];
    }
}
