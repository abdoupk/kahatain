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
            ['academicLevel', 'shirtSize', 'shoesSize', 'pantsSize',
                'sponsorships', 'vocationalTraining',
            ]
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
            __('the_vocational_training'),
            __('the_income'),
            __('unemployed'),
            __('handicapped'),
            __('sponsorships.medical_sponsorship'),
            __('sponsorships.university_scholarship'),
            __('sponsorships.association_trips'),
            __('sponsorships.summer_camp'),
            __('sponsorships.eid_suit'),
            __('sponsorships.private_lessons'),
            __('sponsorships.school_bag'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->getName(),
            $row->birth_date->format('Y-m-d'),
            __($row->gender),
            $row->family_status ? __('family_statuses.' . $row->family_status) : '',
            $row->health_status,
            $row->shirtSize?->label,
            $row->shoesSize?->label,
            $row->pantsSize?->label,
            $row->academicLevel?->level,
            $row->vocationalTraining?->speciality,
            formatCurrency($row->income ?? 0),
            $row->is_unemployed ? __('no') : __('yes'),
            $row->is_handicapped ? __('yes') : __('no'),
            $row->sponsorships->medical_sponsorship ? __('yes') : __('no'),
            $row->sponsorships->university_scholarship ? __('yes') : __('no'),
            $row->sponsorships->association_trips ? __('yes') : __('no'),
            $row->sponsorships->summer_camp ? __('yes') : __('no'),
            $row->sponsorships->eid_suit ? __('yes') : __('no'),
            $row->sponsorships->private_lessons ? __('yes') : __('no'),
            $row->sponsorships->school_bag ? __('yes') : __('no'),
        ];
    }
}
