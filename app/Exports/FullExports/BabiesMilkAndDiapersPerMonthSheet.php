<?php

namespace App\Exports\FullExports;

use App\Models\Archive;
use App\Models\Baby;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class BabiesMilkAndDiapersPerMonthSheet implements FromCollection, WithEvents, WithHeadings, WithTitle
{
    public function __construct(public int $year, public int $month) {}

    public function collection(): Collection
    {
        return Archive::with('listBabies.orphan.sponsor', 'listBabies.babyMilk', 'listBabies.diapers')
            ->whereOccasion('babies_milk_and_diapers')
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get()->map(function (Archive $archive) {
                return $archive->listBabies->map(function (Baby $baby) {
                    return [
                        $baby->orphan->sponsor->getName(),
                        $baby->orphan->sponsor->formattedPhoneNumber(),
                        $baby->orphan->getName(),
                        calculateAge($baby->orphan->birth_date),
                        __($baby->orphan->gender),
                        $baby->babyMilk->name,
                        $baby->baby_milk_quantity,
                        $baby->diapers->name,
                        $baby->diapers_quantity,
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
            __('first_and_last_name'),
            __('age'),
            __('filters.gender'),
            __('baby_milk_type'),
            __('baby_milk_quantity'),
            __('diapers_type'),
            __('diapers_quantity'),
        ];
    }
}
