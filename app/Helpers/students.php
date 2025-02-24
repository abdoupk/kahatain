<?php

use App\Models\AcademicLevel;
use App\Models\AcademicLevelSchoolTool;
use App\Models\Orphan;
use App\Models\Transcript;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

function getPhaseStudents(string $academic_level_id): LengthAwarePaginator
{
    return search(Transcript::getModel(),
        "AND academic_level_id = $academic_level_id"
    )
        ->query(fn ($query) => $query->whereHas('orphan')->with(['subjects', 'orphan']))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function getAcademicLevelsForStudentsIndex(): array
{
    return AcademicLevel::withCount('orphans')
        ->with('transcripts')
        ->where(function ($query): void {
            $query->where('phase_key', 'primary_education')
                ->orWhere('phase_key', 'middle_education')
                ->orWhere('phase_key', 'secondary_education');
        })
        ->get()
        ->mapToGroups(fn (AcademicLevel $academicLevel) => [$academicLevel->phase_key => [
            'level' => $academicLevel->level,
            'id' => $academicLevel->id,
            'orphans_count' => $academicLevel->orphans_count,
            'transcripts' => [
                'first_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'first_trimester')->count(),
                'second_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'second_trimester')->count(),
                'third_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'third_trimester')->count(),
            ],
            'achievement_percentage' => calculateAchievementsPercentage($academicLevel->orphans_count, $academicLevel->transcripts->count()),
        ]])->toArray();
}

function getTotalStudents()
{
    return AcademicLevel::whereHas('orphans')->withCount('orphans')
        ->where(function ($query): void {
            $query->where('phase_key', 'primary_education')
                ->orWhere('phase_key', 'middle_education')
                ->orWhere('phase_key', 'secondary_education');
        })
        ->get()
        ->sum('orphans_count');
}

function getStudentsPerPhase(): array
{
    return Orphan::whereHas('academicLevel', function ($query): void {
        $query->whereIn('phase_key', ['primary_education', 'middle_education', 'secondary_education']);
    })
        ->join('academic_levels', 'orphans.academic_level_id', '=', 'academic_levels.id')
        ->groupBy('academic_levels.phase_key')
        ->selectRaw('academic_levels.phase_key as phase, count(*) as total')
        ->get()
        ->toArray();
}

function calculateAchievementsPercentage(int $orphansCount, int $transcriptsCount): float
{
    $month = now()->month;

    $weight = ($month <= 3) ? 2 : (($month <= 7) ? 3 : (($month === 12 || $month === 11) ? 1 : 0));

    return $transcriptsCount === 0 ? 0 : number_format(($transcriptsCount / ($orphansCount * $weight)) * 100, 2);
}

function generateSchoolTools(): array
{
    // Fetch orphans with their academic level, tools, and branch details
    $orphans = Orphan::whereHas('academicLevel.AcademicLevelSchoolTools.schoolTool', function ($query): void {
        $query->whereIn('phase_key', ['primary_education', 'middle_education', 'secondary_education']);
    })
        ->whereTenantId(tenant('id'))
        ->with([
            'academicLevel' => function ($query): void {
                $query->select('id', 'level', 'phase_key', 'i_id'); // Include i_id for sorting
            },
            'academicLevel.AcademicLevelSchoolTools' => function ($query): void {
                $query->select('id', 'academic_level_id', 'school_tool_id', 'qty')
                    ->with('schoolTool:id,name');
            },
            'family.branch' => function ($query): void {
                $query->select('id', 'name'); // Include branch details
            },
        ])
        ->get();

    // Group data globally by phase
    $globalData = $orphans->flatMap(fn (Orphan $orphan) => $orphan->academicLevel->AcademicLevelSchoolTools->map(fn (AcademicLevelSchoolTool $tool) => [
        'phase_key' => $orphan->academicLevel->phase_key,
        'i_id' => $orphan->academicLevel->i_id,
        'academic_level_id' => $orphan->academicLevel->id,
        'academic_level' => renameAcademicLevel($orphan->academicLevel->level),
        'gender' => $orphan->gender,
        'school_tool_id' => $tool->school_tool_id,
        'school_tool_name' => $tool->schoolTool->name,
        'qty' => $tool->qty,
    ]))
        ->groupBy('phase_key') // Group by phase_key
        ->map(fn (Collection $phaseData) => formatData($phaseData));

    // Group data by branches
    $branchData = $orphans->flatMap(fn (Orphan $orphan) => $orphan->academicLevel->AcademicLevelSchoolTools->map(fn (AcademicLevelSchoolTool $tool) => [
        'branch_id' => $orphan->family->branch?->id ?? null,
        'branch_name' => $orphan->family->branch?->name ?? null,
        'phase_key' => $orphan->academicLevel->phase_key,
        'i_id' => $orphan->academicLevel->i_id,
        'academic_level_id' => $orphan->academicLevel->id,
        'academic_level' => renameAcademicLevel($orphan->academicLevel->level),
        'gender' => $orphan->gender,
        'school_tool_id' => $tool->school_tool_id,
        'school_tool_name' => $tool->schoolTool->name,
        'qty' => $tool->qty,
    ]))
        ->groupBy('branch_id') // Group by branch ID
        ->map(fn (Collection $branchData, $branchId) => [
            'branch_name' => $branchData->first()['branch_name'],
            'data' => $branchData
                ->groupBy('phase_key') // Group by phase_key within each branch
                ->map(fn (Collection $phaseData) => formatData($phaseData)),
        ]);

    // Aggregate tool totals (male, female, total) across all levels and branches
    $toolsData = $orphans->flatMap(fn (Orphan $orphan) => $orphan->academicLevel->AcademicLevelSchoolTools->map(fn (AcademicLevelSchoolTool $tool) => [
        'school_tool_name' => $tool->schoolTool->name,
        'gender' => $orphan->gender,
        'qty' => $tool->qty,
    ]))
        ->groupBy('school_tool_name')
        ->map(function (Collection $toolData) {
            $maleTotal = $toolData->where('gender', 'male')->sum('qty');
            $femaleTotal = $toolData->where('gender', 'female')->sum('qty');
            $globalTotal = $toolData->sum('qty');

            return [
                'male' => $maleTotal,
                'female' => $femaleTotal,
                'total' => $globalTotal,
            ];
        });

    // Return grouped global and branch data
    return [
        'global' => $globalData,
        'branches' => $branchData,
        'totals' => $toolsData,
    ];
}

function formatData(Collection $phaseData)
{
    return $phaseData
        ->groupBy('i_id') // Group by academic level for sorting
        ->sortKeys()
        ->mapWithKeys(function (Collection $toolsByLevel, $academicLevelId) {
            $academicLevelName = $toolsByLevel->first()['academic_level'];

            // Aggregate tools by school_tool_id
            $tools = $toolsByLevel
                ->groupBy('school_tool_id')
                ->map(function (Collection $tools) {
                    $maleTotal = $tools->where('gender', 'male')->sum('qty');
                    $femaleTotal = $tools->where('gender', 'female')->sum('qty');
                    $globalTotal = $tools->sum('qty');

                    return [
                        'name' => $tools->first()['school_tool_name'],
                        'male' => $maleTotal,
                        'female' => $femaleTotal,
                        'total' => $globalTotal,
                    ];
                });

            // Aggregate academic level totals
            $academicLevelTotals = [
                'male' => $tools->sum('male'),
                'female' => $tools->sum('female'),
                'total' => $tools->sum('total'),
            ];

            return [$academicLevelName => [
                'tools' => $tools->values(),
                'totals' => $academicLevelTotals,
            ]];
        });
}

function renameAcademicLevel($levelName): string
{
    return match (true) {
        Str::contains($levelName, 'الثالثة ثانوي تقني رياضي') => 'الثالثة ثانوي تقني رياضي',
        Str::contains($levelName, 'الثانية ثانوي تقني رياضي') => 'الثانية ثانوي تقني رياضي',
        Str::contains($levelName, 'الثانية ثانوي لغات') => 'الثانية ثانوي لغات أجنبية',
        Str::contains($levelName, 'الثالثة ثانوي لغات') => 'الثالثة ثانوي لغات أجنبية',
        default => $levelName,
    };
}

function getStudentsPerSchool(): array
{
    return Orphan::whereHas('academicLevel', function ($query): void {
        $query->whereIn('phase_key', ['primary_education', 'middle_education', 'secondary_education']);
    })->whereHas('institution', function ($query): void {
        $query->where('institution_type', 'school');
    })
        ->join('schools', 'orphans.institution_id', '=', 'schools.id')
        ->groupBy(['schools.id', 'schools.name'])
        ->selectRaw('schools.name as name, count(*) as total')
        ->get()
        ->sortByDesc('total')
        ->take(7)
        ->toArray();
}
