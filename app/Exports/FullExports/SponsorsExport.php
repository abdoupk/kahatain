<?php

namespace App\Exports\FullExports;

use App\Models\Sponsor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class SponsorsExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Sponsor::with(['sponsorships', 'academicLevel', 'incomes'])->get();
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
            __('the_sponsor'),
            __('sponsor_phone_number'),
            __('academic_level'),
            __('the_income'),
            __('filters.birth_date'),
            __('father_name'),
            __('mother_name'),
            __('filters.function'),
            __('health_status'),
            __('diploma'),
            __('filters.sponsor_type'),
            __('ccp'),
            __('validation.attributes.sponsor.birth_certificate_number'),
            __('filters.gender'),
            __('unemployed'),
            __('sponsorships.medical_sponsorship'),
            __('sponsorships.literacy_lessons'),
            __('sponsorships.direct_sponsorship'),
            __('sponsorships.project_support'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->getName(),
            $row->formattedPhoneNumber(),
            $row->academicLevel->level,
            formatCurrency($row->incomes->total_income),
            $row->birth_date,
            $row->father_name,
            $row->mother_name,
            $row->function,
            $row->health_status,
            $row->diploma,
            __('sponsor_types.' . $row->sponsor_type),
            $row->ccp,
            $row->birth_certificate_number,
            __($row->gender),
            $row->is_unemployed ? __('yes') : __('no'),
            $row->sponsorships->medical_sponsorship ?? __('no'),
            $row->sponsorships->literacy_lessons ?? __('no'),
            $row->sponsorships->direct_sponsorship ?? __('no'),
            $row->sponsorships->project_support ?? __('no'),
        ];
    }
}
