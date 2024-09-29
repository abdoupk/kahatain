<?php

namespace App\Exports\FullExports;

use App\Models\Family;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class FamiliesExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Family::with(
            [
                'branch',
                'zone',
                'spouse',
                'secondSponsor',
                'creator',
                'sponsorships',
                'housing',
                'furnishings',
                'sponsor',
                'preview',
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
            __('file_number'),
            __('the_sponsor'),
            __('spouse_name'),
            __('validation.attributes.address'),
            __('the_branch'),
            __('the_zone'),
            __('income_rate'),
            __('incomes.label.total_income'),
            __('validation.attributes.start_date'),
            __('second_sponsor'),
            __('validation.attributes.degree_of_kinship'),
            __('second_sponsor_phone_number'),
            __('second_sponsor_address'),
            __('second_sponsor_income'),
            __('sponsorships.monthly_allowance'),
            __('sponsorships.ramadan_basket'),
            __('sponsorships.zakat'),
            __('sponsorships.eid_al_adha'),
            __('sponsorships.housing_assistance'),
            __('furnishings.television'),
            __('furnishings.refrigerator'),
            __('furnishings.fireplace'),
            __('furnishings.wardrobe'),
            __('furnishings.washing_machine'),
            __('furnishings.water_heater'),
            __('furnishings.oven'),
            __('furnishings.cupboard'),
            __('furnishings.mattresses'),
            __('furnishings.other_furnishings'),
            __('the_report'),
            __('preview_date'),
            __('created_by'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->file_number,
            $row->sponsor?->getName(),
            $row->spouse?->getName(),
            $row->address,
            $row->branch?->name,
            $row->zone?->name,
            $row->income_rate,
            formatCurrency($row->total_income),
            $row->start_date->translatedFormat('j F Y'),
            $row->secondSponsor?->getName(),
            $row->secondSponsor?->degree_of_kinship,
            $row->secondSponsor?->phone_number,
            $row->secondSponsor?->address,
            formatCurrency($row->secondSponsor?->income ?? 0),
            $row->sponsorships->monthly_allowance ?? __('no'),
            $row->sponsorships->ramadan_basket ? __('yes') : __('no'),
            $row->sponsorships->zakat ? __('yes') : __('no'),
            $row->sponsorships->eid_al_adha ? __('yes') : __('no'),
            $row->sponsorships->housing_assistance ? __('yes') : __('no'),
            $row->furnishings->television,
            $row->furnishings->refrigerator,
            $row->furnishings->fireplace,
            $row->furnishings->wardrobe,
            $row->furnishings->washing_machine,
            $row->furnishings->water_heater,
            $row->furnishings->oven,
            $row->furnishings->cupboard,
            $row->furnishings->mattresses,
            $row->furnishings->other_furnishings,
            $row->preview->report,
            $row->preview->preview_date->format('Y-m-d'),
            $row->creator?->getName(),
        ];
    }
}
