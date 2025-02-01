<?php

use App\Models\AcademicLevel;
use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getAcademicLevelsForCollegeStudentsIndex(): array
{
    return AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->whereIn('phase_key', ['master', 'licence', 'doctorate']);
        })
        ->get()
        ->mapToGroups(function (AcademicLevel $academicLevel) {
            return [$academicLevel->phase_key => [
                'level' => $academicLevel->level,
                'id' => $academicLevel->id,
                'orphans_count' => $academicLevel->orphans_count,
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

function getCollegeStudents(): LengthAwarePaginator
{
    return search(Orphan::getModel(), additional_filters: FILTER_COLLEGE_STUDENTS)->query(fn ($query) => $query->with(['institution', 'academicLevel', 'speciality']))->paginate(request()->integer('perPage', 10));
}
