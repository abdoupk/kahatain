<?php

namespace App\Exports\FullExports;

use App\Models\Finance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class FinanceTransactionsExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Finance::with(['receiver', 'creator'])->get();
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
            __('the_amount'),
            __('validation.attributes.specification'),
            __('validation.attributes.description'),
            __('the date'),
            __('receiving_member'),
            __('created_by'),
            __('added_at'),
        ];
    }

    public function map($row): array
    {
        return [
            formatCurrency(abs($row->amount)),
            __($row->specification),
            $row->description,
            $row->amount > 0 ? __('income') : __('expense'),
            $row->date->translatedFormat('j F Y'),
            $row->receiver?->getName(),
            $row->creator?->getName(),
            $row->created_at->translatedFormat('j F Y'),
        ];
    }
}
