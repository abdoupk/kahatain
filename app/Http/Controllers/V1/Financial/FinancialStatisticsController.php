<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class FinancialStatisticsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/financials/statistics/FinancialStatisticsPage', [
            'financesBySpecification' => fn () => getFinancesBySpecification(),
            'financesByType' => fn () => getFinancesByType(),
            'financesByMonth' => fn () => getFinancesByMonth(),
        ]);
    }
}
