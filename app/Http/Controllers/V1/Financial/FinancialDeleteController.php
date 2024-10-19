<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Finance $finance)
    {
        $finance->delete();

        //        dispatch(new FinanceTrashedJob($finance, auth()->user()));

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:delete_financial_transactions'];
    }
}
