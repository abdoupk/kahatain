<?php

namespace App\Exports\FullExports;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class InventoryExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Inventory::with(['creator'])->get();
    }

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
            __('item_name'),
            __('validation.attributes.qty'),
            __('created_by'),
            __('added_at'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->qty.'('.__($row->unit).')',
            $row->creator?->getName(),
            $row->created_at->format('Y-m-d'),
        ];
    }
}
