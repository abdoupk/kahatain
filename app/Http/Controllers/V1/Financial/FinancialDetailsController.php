<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Financial\FinancialTransactionDetailsResource;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialDetailsController extends Controller implements HasMiddleware
{
    public function __invoke(Finance $finance)
    {
        return response()->json([
            'transaction' => FinancialTransactionDetailsResource::make($finance->load(
                [
                    'creator:id,first_name,last_name',
                    'receiver:id,first_name,last_name',
                ]
            )),
        ]);
    }
    public static function middleware()
    {
        return ['can:view_financial_transactions'];
    }
}
