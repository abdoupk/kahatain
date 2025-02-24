<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

class AcademicLevel extends Model
{
    use HasUuids, Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'phase' => $this->phase,
            'phase_key' => $this->phase_key,
            'subjects' => $this->subjects(),
        ];
    }

    public function subjects(): Collection
    {
        return Subject::whereIn('id', $this->subject_ids)
            ->get()->map(fn (Subject $subject) => [
                'id' => $subject->id,
                'name' => $subject->getName(),
            ]);
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }

    public function transcripts(): HasMany
    {
        return $this->hasMany(Transcript::class);
    }

    public function AcademicLevelSchoolTools(): HasMany
    {
        return $this->hasMany(AcademicLevelSchoolTool::class);
        //        return $this->hasManyThrough(SchoolTool::class, AcademicLevelSchoolTool::class, 'academic_level_id', 'id', 'id', 'school_tool_id');
    }

    protected function casts(): array
    {
        return [
            'subject_ids' => 'array',
        ];
    }
}
