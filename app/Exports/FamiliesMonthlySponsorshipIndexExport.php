<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FamiliesMonthlySponsorshipIndexExport implements FromView, WithEvents
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() === 'ar');
            },
        ];
    }

    public function view(): View
    {
        return view('pdf.occasions.monthly-sponsorship-families', [
            'families' => listOfFamiliesBenefitingFromTheMonthlySponsorshipForExport(),
        ]);
    }
}
