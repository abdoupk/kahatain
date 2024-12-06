<?php

use App\Models\AcademicLevel;
use App\Models\Orphan;
use App\Models\Transcript;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
    ray(AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->where('phase_key', 'primary_education')
                ->orWhere('phase_key', 'middle_education')
                ->orWhere('phase_key', 'secondary_education');
        })
        ->get()
        ->sum('orphans_count'));

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
