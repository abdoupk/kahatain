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
        ->query(fn ($query) => $query->with(['subjects', 'orphan']))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function getAcademicLevelsForStudentsIndex(): array
{
    return AcademicLevel::withCount('orphans')
        ->with('transcripts')
        ->where(function ($query) {
            $query->where('phase_key', 'primary_education')
                ->orWhere('phase_key', 'middle_education')
                ->orWhere('phase_key', 'secondary_education');
        })
        ->get()
        ->mapToGroups(function (AcademicLevel $academicLevel) {
            return [$academicLevel->phase_key => [
                'level' => $academicLevel->level,
                'id' => $academicLevel->id,
                'orphans_count' => $academicLevel->orphans_count,
                'transcripts' => [
                    'first_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'first_trimester')->count(),
                    'second_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'second_trimester')->count(),
                    'third_trimester_transcripts_count' => $academicLevel->transcripts->where('trimester', 'third_trimester')->count(),
                ],
                'achievement_percentage' => calculateAchievementsPercentage($academicLevel->orphans_count, $academicLevel->transcripts->count()),
            ]];
        })->toArray();
}

function getTotalStudents()
{

    return AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->where('phase_key', 'primary_education')
                ->orWhere('phase_key', 'middle_education')
                ->orWhere('phase_key', 'secondary_education');
        })
        ->get()
        ->sum('orphans_count');
}

function getStudentsPerPhase(): array
{
    return Orphan::whereHas('academicLevel', function ($query) {
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

function generateSchoolTools()
{
    $orphans = Orphan::whereHas('academicLevel.AcademicLevelSchoolTools.schoolTool', function ($query) {
        $query->whereIn('phase_key', ['primary_education', 'middle_education', 'secondary_education']);
    })
        ->whereTenantId(tenant('id'))
        ->with([
            'academicLevel' => function ($query) {
                $query->select('id', 'level', 'phase_key', 'i_id'); // Include i_id for sorting
            },
            'academicLevel.AcademicLevelSchoolTools' => function ($query) {
                $query->select('id', 'academic_level_id', 'school_tool_id', 'qty')
                    ->with('schoolTool:id,name');
            },
        ])
        ->get();

    // Process data grouped by phase_key and academic_level
    $tableData = $orphans
        ->flatMap(function (Orphan $orphan) {
            return $orphan->academicLevel->AcademicLevelSchoolTools->map(function (AcademicLevelSchoolTool $tool) use ($orphan) {
                return [
                    'phase_key' => $orphan->academicLevel->phase_key,
                    'i_id' => $orphan->academicLevel->i_id, // Use i_id for sorting
                    'academic_level_id' => $orphan->academicLevel->id,
                    'academic_level' => $orphan->academicLevel->level,
                    'gender' => $orphan->gender,
                    'school_tool_id' => $tool->school_tool_id,
                    'school_tool_name' => $tool->schoolTool->name,
                    'qty' => $tool->qty,
                ];
            });
        })
        ->groupBy('phase_key') // Group by phase_key
        ->map(function (Collection $phaseData) {
            return $phaseData
                ->groupBy('academic_level_id') // Group by academic level within each phase
                ->sortBy(fn ($toolsByLevel) => $toolsByLevel->first()['i_id']) // Sort by i_id
                ->mapWithKeys(function (Collection $toolsByLevel, $academicLevelId) {
                    $academicLevelName = $toolsByLevel->first()['academic_level'];

                    $tools = $toolsByLevel
                        ->groupBy('school_tool_id') // Group by tool within each academic level
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

                    // Add totals for each academic level
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
        });

    return $tableData;

}
