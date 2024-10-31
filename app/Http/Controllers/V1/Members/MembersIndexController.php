<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Members\MembersIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class MembersIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_members'];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/members/index/MembersIndexPage', [
            'members' => MembersIndexResource::collection(getMembers()),
            'params' => getParams(),
        ]);
    }
}
