<?php

namespace App\Exports\FullExports;

use App\Models\Baby;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class BabiesExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Baby::with(['orphan.sponsor', 'babyMilk', 'diapers'])->get();
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
            __('orphan_name'),
            __('validation.attributes.age'),
            __('orphan_gender'),
            __('baby_milk_type'),
            __('baby_milk_quantity'),
            __('diapers_type'),
            __('diapers_quantity'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->orphan->sponsor?->getName(),
            $row->orphan->sponsor?->formattedPhoneNumber(),
            $row->orphan->getName(),
            calculateAge($row->orphan->birth_date),
            __($row->orphan->gender),
            $row->babyMilk->name,
            $row->baby_milk_quantity,
            $row->diapers->name,
            $row->diapers_quantity,
        ];
    }
}
