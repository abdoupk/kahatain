<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * @property string $id
 * @property int $i_id
 * @property string $level
 * @property string $phase
 * @property string|null $phase_key
 * @property array<array-key, mixed>|null $subject_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AcademicLevelSchoolTool> $AcademicLevelSchoolTools
 * @property-read int|null $academic_level_school_tools_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Transcript> $transcripts
 * @property-read int|null $transcripts_count
 *
 * @method static Builder<static>|AcademicLevel newModelQuery()
 * @method static Builder<static>|AcademicLevel newQuery()
 * @method static Builder<static>|AcademicLevel query()
 * @method static Builder<static>|AcademicLevel whereIId($value)
 * @method static Builder<static>|AcademicLevel whereId($value)
 * @method static Builder<static>|AcademicLevel whereLevel($value)
 * @method static Builder<static>|AcademicLevel wherePhase($value)
 * @method static Builder<static>|AcademicLevel wherePhaseKey($value)
 * @method static Builder<static>|AcademicLevel whereSubjectIds($value)
 *
 * @mixin Eloquent
 */
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
