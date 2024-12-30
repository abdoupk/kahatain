<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Models\Benefactor;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorDestroyController extends Controller implements HasMiddleware
{
    public function __invoke(Benefactor $benefactor)
    {
        $benefactor->delete();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:delete_benefactors'];
    }
}
