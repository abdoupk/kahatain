<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Models\Benefactor;

class BenefactorDestroyController extends Controller
{
    public function __invoke(Benefactor $benefactor)
    {
        $benefactor->delete();

        return redirect()->back();
    }
}
