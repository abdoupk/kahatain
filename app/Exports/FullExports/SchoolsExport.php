<?php

namespace App\Exports\FullExports;

use App\Models\PrivateSchool;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class SchoolsExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return PrivateSchool::with(['subjects', 'creator'])->withCount(['lessons', 'subjects'])->get();
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
            __('name'),
            __('lessons_count'),
            __('subjects_count'),
            __('the_subjects'),
            __('validation.attributes.created_at'),
            __('created_by'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->lessons_count,
            $row->subjects_count,
            $row->subjects->pluck('name')->implode(', '),
            $row->created_at->format('Y-m-d'),
            $row->creator?->getName(),
        ];
    }
}
