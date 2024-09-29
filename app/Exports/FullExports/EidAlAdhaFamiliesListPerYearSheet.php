<?php

namespace App\Exports\FullExports;

use App\Models\Archive;
use App\Models\Family;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EidAlAdhaFamiliesListPerYearSheet implements FromCollection, WithEvents, WithHeadings, WithTitle
{
    public function __construct(public int $year)
    {
    }

    public function collection(): Collection
    {
        return Archive::whereOccasion('eid_al_adha')
            ->whereYear('created_at', $this->year)
            ->get()
            ->map(function (Archive $archive) {
                return $archive->listFamilies
                    ->load(
                        'branch:id,name',
                        'zone:id,name',
                        'sponsor:id,family_id,first_name,last_name,phone_number'
                    )
                    ->map(function (Family $family) {
                        return [
                            $family->sponsor->getName(),
                            $family->sponsor->formattedPhoneNumber(),
                            $family->address,
                            $family->zone->name,
                            $family->branch->name,
                            formatCurrency($family->total_income ?? 0),
                            $family->income_rate,
                        ];
                    });
            });
    }

    public function title(): string
    {
        return $this->year;
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
            trans('the_sponsor'),
            trans('sponsor_phone_number'),
            trans('validation.attributes.address'),
            trans('the_zone'),
            trans('the_branch'),
            trans('incomes.label.total_income'),
            trans('income_rate'),
        ];
    }
}
