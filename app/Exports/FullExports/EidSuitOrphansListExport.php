<?php

namespace App\Exports\FullExports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class EidSuitOrphansListExport implements WithEvents, WithMultipleSheets
{
    public function __construct(public array $years)
    {
    }

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

        foreach ($this->years as $year) {
            $sheets[] = new EidSuitOrphansListPerYearSheet($year);
        }

        return $sheets;
    }
}
