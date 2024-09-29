<?php

namespace App\Exports\FullExports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
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
            __('full_name'),
            __('validation.attributes.email'),
            __('validation.attributes.phone_number'),
            __('validation.attributes.qualification'),
            __('validation.attributes.gender'),
            __('validation.attributes.address'),
            __('validation.attributes.zone_id'),
            __('validation.attributes.branch_id'),
            __('validation.attributes.role'),
            __('added_at'),
        ];
    }

    public function collection(): Collection
    {
        setPermissionsTeamId(tenant('id'));

        return User::with(['zone', 'branch', 'roles'])->get();
    }

    public function map($row): array
    {
        return [
            $row->getName(),
            $row->email,
            $row->phone,
            $row->qualification,
            __($row->gender),
            $row->address,
            $row->zone?->name,
            $row->branch?->name,
            $row->roles->pluck('name')->implode(__('glue')),
            $row->created_at->translatedFormat('j F Y'),
        ];
    }
}
