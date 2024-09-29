<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberForceDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(User $member): Response
    {
        $member->forceDelete();

        return response('', 204);
    }
    public static function middleware()
    {
        return ['can:destroy_trash'];
    }
}
