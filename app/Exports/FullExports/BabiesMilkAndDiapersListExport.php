<?php

namespace App\Exports\FullExports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class BabiesMilkAndDiapersListExport implements WithEvents, WithMultipleSheets
{
    public function __construct(public int $year) {}

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() === 'ar');
            },
        ];
    }

    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new BabiesMilkAndDiapersPerMonthSheet($this->year, $month);
        }

        return $sheets;
    }
}
