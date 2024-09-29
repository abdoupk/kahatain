<?php

namespace App\Exports\FullExports;

use App\Models\Zone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ZonesExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() === 'ar');
            },
        ];
    }

    public function headings(): array
    {
        return [
            __('zone name'),
            __('validation.attributes.description'),
            __('added_at'),
            __('created_by'),
        ];
    }

    public function collection(): Collection
    {
        return Zone::with('creator')->select(['name', 'description', 'created_at', 'created_by'])->get();
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->description,
            $row->created_at->translatedFormat('j F Y'),
            $row->creator?->getName(),
        ];
    }
}
