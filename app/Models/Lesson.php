<?php

namespace App\Models;

use Database\Factories\LessonFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property int $subject_id
 * @property string $academic_level_id
 * @property string $private_school_id
 * @property int $quota
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Collection<int, EventOccurrence> $orphans
 * @property-read int|null $orphans_count
 * @property-read PrivateSchool $school
 * @property-read Subject|null $subject
 * @property-read Tenant $tenant
 *
 * @method static LessonFactory factory($count = null, $state = [])
 * @method static Builder<static>|Lesson newModelQuery()
 * @method static Builder<static>|Lesson newQuery()
 * @method static Builder<static>|Lesson onlyTrashed()
 * @method static Builder<static>|Lesson query()
 * @method static Builder<static>|Lesson whereAcademicLevelId($value)
 * @method static Builder<static>|Lesson whereCreatedAt($value)
 * @method static Builder<static>|Lesson whereDeletedAt($value)
 * @method static Builder<static>|Lesson whereEndDate($value)
 * @method static Builder<static>|Lesson whereId($value)
 * @method static Builder<static>|Lesson wherePrivateSchoolId($value)
 * @method static Builder<static>|Lesson whereQuota($value)
 * @method static Builder<static>|Lesson whereStartDate($value)
 * @method static Builder<static>|Lesson whereSubjectId($value)
 * @method static Builder<static>|Lesson whereTenantId($value)
 * @method static Builder<static>|Lesson whereUpdatedAt($value)
 * @method static Builder<static>|Lesson withTrashed()
 * @method static Builder<static>|Lesson withoutTrashed()
 *
 * @mixin Eloquent
 */
class Lesson extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'subject_id',
        'academic_level_id',
        'quota',
        'start_date',
        'end_date',
        'id',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(PrivateSchool::class, 'private_school_id', 'id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id', 'id');
    }

    public function orphans(): HasManyThrough
    {
        return $this->hasManyThrough(EventOccurrence::class, Orphan::class, 'lesson_id', 'id', 'id', 'event_id');
    }

    public function getName(): string
    {
        return $this->subject->getName().' - '.$this->academicLevel?->level;
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
        ];
    }
}
