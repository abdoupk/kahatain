<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Financial\FinancialUpdateResource;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_financial_transactions'];
    }

    public function __invoke(Finance $finance)
    {
        return response()->json([
            'finance' => FinancialUpdateResource::make($finance),
        ]);
    }
}
