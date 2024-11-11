<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FamiliesEidAlAdhaIndexExport implements FromView, WithEvents
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
        return view('pdf.occasions.eid-al-adha-families', [
            'families' => listOfFamiliesBenefitingFromTheEidAlAdhaSponsorshipForExport(),
        ]);
    }
}
