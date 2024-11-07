<?php

use App\Models\Sponsor;
use App\Models\SponsorSponsorship;

function getSponsorsBySponsorType(): array
{
    $sponsors = Sponsor::select('sponsor_type', DB::raw('count(*) as total'))->groupBy('sponsor_type')->get();

    return [
        'labels' => $sponsors->pluck('sponsor_type')->map(function (string $sponsor_type) {
            return __('sponsor_types.'.$sponsor_type);
        })->toArray(),
        'data' => $sponsors->pluck('total')->toArray(),
    ];
}

function getSponsorsByAcademicLevel(): array
{
    $sponsors = Sponsor::whereNotNull('academic_level_id')->select('academic_level_id', DB::raw('count(*) as total'))->with('academicLevel:id,phase')
        ->groupBy('academic_level_id')
        ->get();

    $result = $sponsors->groupBy(function ($orphan) {
        return $orphan->academicLevel?->phase;
    })->map(function ($group) {
        return [
            'total' => $group->count(),
            'phase' => $group->first()->academicLevel?->phase,
        ];
    })->values()->toArray();

    return [
        'labels' => array_column($result, 'phase'),
        'data' => array_column($result, 'total'),
    ];
}

function getSponsorsBySponsorship(): array
{
    $sponsorships = SponsorSponsorship::selectRaw('
    SUM(CASE WHEN literacy_lessons != \'0\' THEN 1 ELSE 0 END) AS literacy_lessons_count,
    SUM(CASE WHEN direct_sponsorship != \'0\' THEN 1 ELSE 0 END) AS direct_sponsorship_count,
    SUM(CASE WHEN project_support != \'0\' THEN 1 ELSE 0 END) AS project_support_count,
     SUM(CASE WHEN medical_sponsorship != \'0\' THEN 1 ELSE 0 END) AS medical_sponsorship_count
')
        ->first();

    return [
        'literacy_lessons' => $sponsorships->literacy_lessons_count,
        'direct_sponsorship' => $sponsorships->direct_sponsorship_count,
        'project_support' => $sponsorships->project_support_count,
        'medical_sponsorship' => $sponsorships->medical_sponsorship_count,
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
