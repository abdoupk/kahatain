<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Benefactor\BenefactorTrashedJob;
use App\Models\Benefactor;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorDestroyController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_benefactors'];
    }

    public function __invoke(Benefactor $benefactor)
    {
        $benefactor->delete();

        dispatch(new BenefactorTrashedJob($benefactor, auth()->user()));

        return redirect()->back();
    }
}
