<?php

namespace App\Exports\FullExports;

use App\Models\Archive;
use App\Models\Family;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class MonthlyBasketPerMonthSheet implements FromCollection, WithEvents, WithHeadings, WithTitle
{
    public function __construct(public int $year, public int $month) {}

    public function collection(): Collection
    {
        return Archive::with(
            'listFamilies.sponsor:id,family_id,first_name,last_name,phone_number',
            'listFamilies.zone:id,name',
            'listFamilies.branch:id,name',
            'listFamilies:start_date,id,income_rate,address,total_income,zone_id,branch_id'
        )
            ->whereOccasion('monthly_basket')
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get()->map(function (Archive $archive) {
                return $archive->listFamilies->map(function (Family $family) {
                    return [
                        $family->sponsor->getName(),
                        $family->sponsor->formattedPhoneNumber(),
                        $family->address,
                        $family->zone->name,
                        $family->branch->name,
                        formatCurrency($family->total_income ?? 0),
                        $family->income_rate,
                        $family->start_date->format('Y-m-d'),
                    ];
                });
            });
    }

    public function title(): string
    {
        return Carbon::createFromDate(2024, $this->month, 1)->getTranslatedMonthName();
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
            __('validation.attributes.address'),
            __('the_zone'),
            __('the_branch'),
            __('incomes.label.total_income'),
            __('income_rate'),
            __('validation.attributes.starting_sponsorship_date'),
        ];
    }
}
