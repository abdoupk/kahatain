<?php

namespace App\Exports\FullExports;

use App\Models\Orphan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OrphansExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Orphan::with(
            ['academicLevel', 'shirtSize', 'shoesSize', 'pantsSize', 'institution', 'speciality']
        )->get();
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
            __('first_and_last_name'),
            __('filters.birth_date'),
            __('filters.gender'),
            __('family_status'),
            __('health_status'),
            __('shirt_size'),
            __('shoes_size'),
            __('pants_size'),
            __('academic_level'),
            __('validation.attributes.institution'),
            __('speciality'),
            __('academic_level'),
            __('the_income'),
            __('unemployed'),
            __('handicapped'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->getName(),
            $row->birth_date->format('Y-m-d'),
            __($row->gender),
            $row->family_status ? __('family_statuses.'.$row->family_status) : '',
            $row->health_status,
            $row->shirtSize?->label,
            $row->shoesSize?->label,
            $row->pantsSize?->label,
            $row->academicLevel?->level,
            $row->institution?->getName(),
            $row->speciality?->speciality ?? '----',
            formatCurrency($row->income ?? 0),
            $row->is_unemployed ? __('no') : __('yes'),
            $row->is_handicapped ? __('yes') : __('no'),
        ];
    }
}
