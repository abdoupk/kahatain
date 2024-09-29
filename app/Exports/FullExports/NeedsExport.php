<?php

namespace App\Exports\FullExports;

use App\Models\Need;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class NeedsExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Need::with(['creator', 'needable'])->get();
    }

    public function map($row): array
    {
        return [
            $row->subject,
            $row->demand,
            __($row->status),
            $row->note,
            $row->needable?->getName(),
            $row->creator?->getName(),
            $row->created_at->translatedFormat('j F Y H:i A'),
        ];
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
            __('the_subject'),
            __('the_demand'),
            __('validation.attributes.status'),
            __('notes'),
            __('the_requester'),
            __('created_by'),
            __('added_at'),
        ];
    }
}
