<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberRestoreController extends Controller implements HasMiddleware
{
    public function __invoke(User $member)
    {
        $member->restore();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:restore_trash'];
    }
}
