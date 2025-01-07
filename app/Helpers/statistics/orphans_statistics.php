<?php

use App\Models\Orphan;

function getOrphansByFamilyStatus(): array
{
    $orphans = Orphan::select('family_status', DB::raw('count(*) as total'))->where('family_status', '!=', null)->groupBy('family_status')->get();

    return [
        'labels' => $orphans->pluck('family_status')->map(function (string $familyStatus) {
            return __('family_statuses.'.$familyStatus);
        })->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}

function getOrphansByAcademicLevel(): array
{
    $orphans = Orphan::whereNotNull('academic_level_id')
        ->select(
            'academic_level_id',
            DB::raw('count(*) as total')
        )
        ->with('academicLevel:id,phase')
        ->groupBy('academic_level_id')
        ->get();

    $result = $orphans->groupBy(function ($orphan) {
        return $orphan->academicLevel?->phase;
    })->map(function ($group) {
        return [
            'total' => $group->first()->total,
            'phase' => $group->first()->academicLevel?->phase,
        ];
    })->values()->toArray();

    return [
        'labels' => array_column($result, 'phase'),
        'data' => array_column($result, 'total'),
    ];
}

function getOrphansByGender(): array
{
    $orphans = Orphan::select('gender', DB::raw('count(*) as total'))->groupBy('gender')->get();

    return [
        'labels' => $orphans->pluck('gender')->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}

function getOrphansByAge(): array
{
    $orphans = Orphan::selectRaw('EXTRACT(YEAR FROM NOW()) - EXTRACT(YEAR FROM birth_date) AS age, COUNT(*) AS count')
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    return [
        'age' => array_reverse($orphans->pluck('age')->map(function (int $age) {
            return trans_choice('age_years', $age, ['value' => $age]);
        })->toArray()),
        'data' => array_reverse($orphans->pluck('count')->toArray()),
    ];
}

function getOrphansByZone(): array
{
    $orphans = Orphan::selectRaw('z.id, z.name, COUNT(*) as total')
        ->join('families as f', 'f.id', '=', 'orphans.family_id')
        ->join('zones as z', 'z.id', '=', 'f.zone_id')
        ->groupBy('z.id', 'z.name')
        ->get();

    return [
        'labels' => $orphans->pluck('name')->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}

function getOrphansByBranch(): array
{
    $orphans = Orphan::selectRaw('b.id, b.name, COUNT(*) as total')
        ->join('families as f', 'f.id', '=', 'orphans.family_id')
        ->join('branches as b', 'b.id', '=', 'f.branch_id')
        ->groupBy('b.id', 'b.name')
        ->get();

    return [
        'labels' => $orphans->pluck('name')->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}

function getByPantsAndShirtSize(): array
{
    $shirt_sizes = Orphan::whereNotNull('shirt_size')->whereNotNull('pants_size')->selectRaw('shirt_size, COUNT(*) as total')
        ->with('shirtSize:id,label')
        ->groupBy('shirt_size')
        ->get()
        ->mapWithKeys(function ($item) {
            if ($item->shirtSize?->label) {
                return [$item->shirtSize->label => $item->total];
            }

            return [];
        });

    $pants_sizes = Orphan::whereNotNull('pants_size')->selectRaw('pants_size, COUNT(*) as total')
        ->with('pantsSize:id,label')
        ->groupBy('pants_size')
        ->get()
        ->mapWithKeys(function ($item) {
            if ($item->pantsSize?->label) {
                return [$item->pantsSize->label => $item->total];
            }

            return [];
        });

    $all_labels = array_unique(array_merge(array_keys($shirt_sizes->toArray()), array_keys($pants_sizes->toArray())));

    $shirts_data = [];
    $pants_data = [];

    foreach ($all_labels as $label) {
        $shirts_data[] = $shirt_sizes->get($label, 0);
        $pants_data[] = $pants_sizes->get($label, 0);
    }

    return [
        'labels' => $all_labels,
        'shirts_data' => $shirts_data,
        'pants_data' => $pants_data,
    ];
}

function getOrphansByShoeSize(): array
{
    $orphans = Orphan::whereNotNull('shoes_size')
        ->select(
            'shoes_size',
            DB::raw('count(*) as total')
        )->with('shoesSize:id,label')
        ->groupBy('shoes_size')
        ->orderBy('shoes_size')
        ->get();

    return [
        'labels' => $orphans->pluck('shoesSize.label')->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}

function getOrphansGroupByCreatedDate(): array
{
    return array_replace(
        array_fill(1, 13, 0),
        Orphan::query()
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as orphans_count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('orphans_count', 'month')
            ->toArray()
    );
}

function getOrphansGroupHealthStatus(): array
{
    $orphans = Orphan::select(
        'is_handicapped',
        DB::raw('count(*) as total')
    )->groupBy('is_handicapped')
        ->get();

    return [
        'labels' => $orphans->pluck('is_handicapped')
            ->map(fn ($is_handicapped) => $is_handicapped
                ? __('statistics.handicapped')
                : __('statistics.healthy'))->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}
