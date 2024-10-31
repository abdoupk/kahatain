<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Financial\FinancialUpdateRequest;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_financial_transactions'];
    }

    public function __invoke(FinancialUpdateRequest $request, Finance $finance)
    {
        $finance->update([
            ...$request->only(['specification', 'description', 'date']),
            'amount' => $request->type === 'income' ? abs($request->amount) : abs($request->amount) * -1,
        ]);

        //        dispatch(new FinanceUpdatedJob($finance, auth()->user()));

        return response('', 201);
    }
}
