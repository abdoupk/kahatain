<?php

use App\Models\AcademicLevel;
use App\Models\Orphan;

function getAcademicLevelsForCollegeStudentsIndex(): array
{
    return AcademicLevel::withCount('orphans')
        ->with('highEducationTranscripts')
        ->where(function ($query) {
            $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
        })
        ->get()
        ->mapToGroups(function (AcademicLevel $academicLevel) {
            return [$academicLevel->phase_key => [
                'level' => $academicLevel->level,
                'id' => $academicLevel->id,
                'orphans_count' => $academicLevel->orphans_count,
                'transcripts' => [
                    'first_semester_transcripts_count' => $academicLevel->highEducationTranscripts->where('semester', 'first_semester')->count(),
                    'second_semester_transcripts_count' => $academicLevel->highEducationTranscripts->where('semester', 'second_semester')->count(),
                ],
                'achievement_percentage' => calculateHighEducationTranscriptsAchievementsPercentage($academicLevel->orphans_count, $academicLevel->highEducationTranscripts->count()),
            ]];
        })->toArray();
}

function getTotalCollegeStudents()
{
    return AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
        })
        ->get()
        ->sum('orphans_count');
}

function getCollegeStudentsPerPhase(): array
{
    return Orphan::whereHas('academicLevel', function ($query) {
        $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
    })
        ->join('academic_levels', 'orphans.academic_level_id', '=', 'academic_levels.id')
        ->groupBy('academic_levels.phase_key')
        ->selectRaw('academic_levels.phase_key as phase, count(*) as total')
        ->get()
        ->toArray();
}

function getCollegeStudentsPerUniversity(): array
{
    return Orphan::whereHas('academicLevel', function ($query) {
        $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
    })->whereHas('institution', function ($query) {
        $query->where('institution_type', 'university');
    })
        ->join('universities', 'orphans.institution_id', '=', 'universities.id')
        ->groupBy(['universities.id', 'universities.name'])
        ->selectRaw('universities.name as name, count(*) as total')
        ->get()
        ->sortByDesc('total')
        ->take(7)
        ->toArray();
}

function calculateHighEducationTranscriptsAchievementsPercentage(int $orphansCount, int $transcriptsCount): float
{
    $month = now()->month;

    $weight = ($month <= 2) ? 1 : (($month <= 7) ? 2 : 0);

    return $transcriptsCount === 0 ? 0 : number_format(($transcriptsCount / ($orphansCount * $weight)) * 100, 2);
}

function getCollegeStudents()
{
    return Orphan::whereHas('academicLevel', function ($query) {
        $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
    })->with(['highEducationTranscripts', 'institution'])->get();
}
