<?php

use App\Models\AcademicLevel;
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
        ->where(function ($query) {
            $query->where('phase_key', 'elementary_school')
                ->orWhere('phase_key', 'middle_school')
                ->orWhere('phase_key', 'high_school');
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
