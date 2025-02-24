<?php

use App\Models\Sponsor;

function getSponsorsBySponsorType(): array
{
    $sponsors = Sponsor::select('sponsor_type', DB::raw('count(*) as total'))->groupBy('sponsor_type')->get();

    return [
        'labels' => $sponsors->pluck('sponsor_type')->map(fn (string $sponsor_type) => __('sponsor_types.'.$sponsor_type))->toArray(),
        'data' => $sponsors->pluck('total')->toArray(),
    ];
}

function getSponsorsByAcademicLevel(): array
{
    $sponsors = Sponsor::whereNotNull('academic_level_id')->select('academic_level_id', DB::raw('count(*) as total'))->with('academicLevel:id,phase')
        ->groupBy('academic_level_id')
        ->get();

    $result = $sponsors->groupBy(fn ($orphan) => $orphan->academicLevel?->phase)->map(fn ($group) => [
        'total' => $group->count(),
        'phase' => $group->first()->academicLevel?->phase,
    ])->values()->toArray();

    return [
        'labels' => array_column($result, 'phase'),
        'data' => array_column($result, 'total'),
    ];
}

function getSponsorsByDiploma(): array
{
    $sponsors = Sponsor::select('diploma', DB::raw('count(*) as total'))->groupBy('diploma')->get();

    return [
        'labels' => $sponsors->pluck('diploma')->toArray(),
        'data' => $sponsors->pluck('total')->toArray(),
    ];
}
