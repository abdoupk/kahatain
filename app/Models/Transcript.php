<?php

namespace App\Models;

use Database\Factories\TranscriptFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $trimester
 * @property string $orphan_id
 * @property string $tenant_id
 * @property string $academic_level_id
 * @property float $average
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Orphan|null $orphan
 * @property-read SubjectTranscript|null $pivot
 * @property-read Collection<int, Subject> $subjects
 * @property-read int|null $subjects_count
 * @property-read Tenant|null $tenant
 *
 * @method static TranscriptFactory factory($count = null, $state = [])
 * @method static Builder<static>|Transcript newModelQuery()
 * @method static Builder<static>|Transcript newQuery()
 * @method static Builder<static>|Transcript query()
 * @method static Builder<static>|Transcript whereAcademicLevelId($value)
 * @method static Builder<static>|Transcript whereAverage($value)
 * @method static Builder<static>|Transcript whereCreatedAt($value)
 * @method static Builder<static>|Transcript whereId($value)
 * @method static Builder<static>|Transcript whereOrphanId($value)
 * @method static Builder<static>|Transcript whereTenantId($value)
 * @method static Builder<static>|Transcript whereTrimester($value)
 * @method static Builder<static>|Transcript whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Transcript extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'trimester',
        'orphan_id',
        'tenant_id',
        'academic_level_id',
        'average',
    ];

    public function toSearchableArray(): array
    {
        return [
            'trimester' => $this->trimester,
            'average' => $this->average,
            'first_trimester' => $this->subjects()->get()->mapWithKeys(function ($subject, $index) {
                return ['grade_'.$index => (float) $subject->pivot->grade];
            })->toArray(),
            'orphan_id' => $this->orphan_id,
            'academic_level_id' => $this->academic_level_id,
            'tenant_id' => $this->tenant_id,
        ];
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->withPivot('grade')
            ->using(SubjectTranscript::class);
    }

    public function academicLevel(): HasOneThrough
    {
        return $this->hasOneThrough(AcademicLevel::class, Orphan::class, 'id', 'id', 'orphan_id', 'academic_level_id');
    }

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }
}
