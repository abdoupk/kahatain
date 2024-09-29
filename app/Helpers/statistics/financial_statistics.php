<?php

use App\Models\Finance;

function getFinancesBySpecification(): array
{
    $finances = Finance::selectRaw('
          SUM(CASE WHEN amount < 0 and specification = \'school_entry\' THEN amount ELSE 0 END) as expenses_school_entry, SUM(CASE WHEN amount >= 0 and specification = \'school_entry\' THEN amount ELSE 0 END) as incomes_school_entry,

          SUM(CASE WHEN amount < 0 and specification = \'ramadan_basket\' THEN amount ELSE 0 END) as expenses_ramadan_basket, SUM(CASE WHEN amount >= 0 and specification = \'ramadan_basket\' THEN amount ELSE 0 END) as incomes_ramadan_basket,

          SUM(CASE WHEN amount < 0 and specification = \'therapy\' THEN amount ELSE 0 END) as expenses_therapy, SUM(CASE WHEN amount >= 0 and specification = \'therapy\' THEN amount ELSE 0 END) as incomes_therapy,

          SUM(CASE WHEN amount < 0 and specification = \'analysis\' THEN amount ELSE 0 END) as expenses_analysis, SUM(CASE WHEN amount >= 0 and specification = \'analysis\' THEN amount ELSE 0 END) as incomes_analysis,

          SUM(CASE WHEN amount < 0 and specification = \'other\' THEN amount ELSE 0 END) as expenses_other, SUM(CASE WHEN amount >= 0 and specification = \'other\' THEN amount ELSE 0 END) as incomes_other,

          SUM(CASE WHEN amount < 0 and specification = \'eid_el_fitr\' THEN amount ELSE 0 END) as expenses_eid_el_fitr, SUM(CASE WHEN amount >= 0 and specification = \'eid_el_fitr\' THEN amount ELSE 0 END) as incomes_eid_el_fitr,

          SUM(CASE WHEN amount < 0 and specification = \'eid_el_adha\' THEN amount ELSE 0 END) as expenses_eid_el_adha, SUM(CASE WHEN amount >= 0 and specification = \'eid_el_adha\' THEN amount ELSE 0 END) as incomes_eid_el_adha,

          SUM(CASE WHEN amount < 0 and specification = \'monthly_sponsorship\' THEN amount ELSE 0 END) as expenses_monthly_sponsorship, SUM(CASE WHEN amount >= 0 and specification = \'monthly_sponsorship\' THEN amount ELSE 0 END) as incomes_monthly_sponsorship,

          SUM(CASE WHEN amount < 0 and specification = \'drilling_wells\' THEN amount ELSE 0 END) as expenses_drilling_wells, SUM(CASE WHEN amount >= 0 and specification = \'drilling_wells\' THEN amount ELSE 0 END) as incomes_drilling_wells
        ')
        ->whereYear('created_at', now()->year)
        ->first();

    return [
        'incomes' => [
            'school_entry' => $finances->incomes_school_entry,
            'drilling_wells' => $finances->incomes_drilling_wells,
            'ramadan_basket' => $finances->incomes_ramadan_basket,
            'therapy' => $finances->incomes_therapy,
            'analysis' => $finances->incomes_analysis,
            'other' => $finances->incomes_other,
            'eid_el_fitr' => $finances->incomes_eid_el_fitr,
            'eid_el_adha' => $finances->incomes_eid_el_adha,
            'monthly_sponsorship' => $finances->incomes_monthly_sponsorship,
        ],
        'expenses' => [
            'school_entry' => abs($finances->expenses_school_entry),
            'drilling_wells' => abs($finances->expenses_drilling_wells),
            'ramadan_basket' => abs($finances->expenses_ramadan_basket),
            'therapy' => abs($finances->expenses_therapy),
            'analysis' => abs($finances->expenses_analysis),
            'other' => abs($finances->expenses_other),
            'eid_el_fitr' => abs($finances->expenses_eid_el_fitr),
            'eid_el_adha' => abs($finances->expenses_eid_el_adha),
            'monthly_sponsorship' => abs($finances->expenses_monthly_sponsorship),
        ],
    ];
}

function getFinancesByType(): array
{
    $result = [
        'incomes' => array_fill(0, 12, 0),
        'expenses' => array_fill(0, 12, 0),
    ];

    Finance::selectRaw('
            EXTRACT(MONTH FROM created_at) as month, SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) as negative_amount, SUM(CASE WHEN amount >= 0 THEN amount ELSE 0 END) as positive_amount
        ')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->get()
        ->groupBy('month')
        ->map(function ($items) use (&$result): void {
            $items->each(function ($item) use (&$result): void {
                $monthIndex = $item->month - 1;
                $result['incomes'][$monthIndex] = $item->positive_amount;
                $result['expenses'][$monthIndex] = abs($item->negative_amount);
            });
        });

    return $result;
}

function getFinancesByMonth(): array
{
    return generateFinancialReport();
}
