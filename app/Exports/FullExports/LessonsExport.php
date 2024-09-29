<?php

namespace App\Exports\FullExports;

use App\Models\Event;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class LessonsExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Event::with(['school', 'subject'])->get();
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
            __('validation.attributes.title'),
            __('the_school'),
            __('the_subject'),
            __('validation.attributes.start_date'),
            __('validation.attributes.end_date'),
            __('validation.attributes.frequency'),
            __('validation.attributes.interval'),
            __('validation.attributes.until'),
            __('created_by'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->title,
            $row->school->name,
            $row->subject->getName(),
            $row->start_date,
            $row->end_date,
            $row->frequency,
            $row->interval,
            $row->until,
            $row->creator?->getName(),
        ];
    }
}
