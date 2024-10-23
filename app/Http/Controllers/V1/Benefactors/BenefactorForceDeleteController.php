<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Models\Benefactor;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:destroy_trash',
        ];
    }

    public function __invoke(Benefactor $benefactor)
    {
        $benefactor->forceDelete();

        return response('', 204);
    }
}
