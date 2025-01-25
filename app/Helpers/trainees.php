<?php

use App\Models\AcademicLevel;
use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getAcademicLevelsForTraineesIndex(): array
{
    return AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->where('phase_key', 'paramedical')
                ->orWhere('phase_key', 'vocational_training');
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

function getTotalTrainees()
{
    return AcademicLevel::withCount('orphans')
        ->where(function ($query) {
            $query->where('phase_key', 'paramedical')
                ->orWhere('phase_key', 'vocational_training');
        })
        ->get()
        ->sum('orphans_count');
}

function getTraineesPerPhase(): array
{
    return Orphan::whereHas('academicLevel', function ($query) {
        $query->whereIn('phase_key', ['paramedical', 'vocational_training']);
    })
        ->join('academic_levels', 'orphans.academic_level_id', '=', 'academic_levels.id')
        ->groupBy('academic_levels.phase_key')
        ->selectRaw('academic_levels.phase_key as phase, count(*) as total')
        ->get()
        ->toArray();
}

function getTraineesPerVocationalTrainingCenter(): array
{
    return Orphan::whereHas('academicLevel', function ($query) {
        $query->whereIn('phase_key', ['paramedical', 'vocational_training']);
    })->whereHas('institution', function ($query) {
        $query->where('institution_type', 'vocational_training_center');
    })
        ->join('vocational_training_centers', 'orphans.institution_id', '=', 'vocational_training_centers.id')
        ->groupBy(['vocational_training_centers.id', 'vocational_training_centers.arabic_name'])
        ->selectRaw('vocational_training_centers.arabic_name as name, count(*) as total')
        ->get()
        ->sortByDesc('total')
        ->take(7)
        ->toArray();
}

function getTraineesStudents(): LengthAwarePaginator
{
    return search(Orphan::getModel(), additional_filters: FILTER_TRAINEES_ORPHANS)->query(fn ($query) => $query->with(['institution', 'academicLevel']))->paginate(request()->integer('perPage', 10));
}
