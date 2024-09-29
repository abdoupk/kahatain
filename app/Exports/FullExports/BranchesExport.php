<?php

namespace App\Exports\FullExports;

use App\Models\Branch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class BranchesExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Branch::with(['creator', 'president', 'city'])->withCount('families')->get();
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
            __('branch_name'),
            __('branch_president'),
            __('location'),
            __('families_count'),
            __('validation.attributes.created_at'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->president?->getName(),
            $row->city?->getFullName(app()->getLocale()),
            $row->families_count,
            $row->created_at->translatedFormat('j F Y'),
        ];
    }
}
