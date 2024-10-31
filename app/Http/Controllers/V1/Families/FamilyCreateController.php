<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Members\MemberResource;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamilyCreateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_families'];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/families/create/FamilyCreatePage', [
            'members' => MemberResource::collection(User::select(['id', 'first_name', 'last_name'])->get()),
        ]);
    }
}
