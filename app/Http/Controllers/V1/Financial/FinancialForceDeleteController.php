<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialForceDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Finance $finance)
    {
        $finance->forceDelete();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:destroy_trash'];
    }
}
