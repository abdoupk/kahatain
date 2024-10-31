<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Member\MemberTrashedJob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_members'];
    }

    public function __invoke(User $member): RedirectResponse
    {
        $member->delete();

        dispatch(new MemberTrashedJob($member, auth()->user()));

        return redirect()->back();
    }
}
