<?php

namespace App\Models;

use Database\Factories\LessonFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @property int $academic_level_id
 * @property string $private_school_id
 * @property int $quota
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read PrivateSchool $school
 * @property-read Subject|null $subject
 * @property-read Tenant $tenant
 *
 * @method static LessonFactory factory($count = null, $state = [])
 * @method static Builder|Lesson newModelQuery()
 * @method static Builder|Lesson newQuery()
 * @method static Builder|Lesson onlyTrashed()
 * @method static Builder|Lesson query()
 * @method static Builder|Lesson whereAcademicLevelId($value)
 * @method static Builder|Lesson whereCreatedAt($value)
 * @method static Builder|Lesson whereDeletedAt($value)
 * @method static Builder|Lesson whereId($value)
 * @method static Builder|Lesson wherePrivateSchoolId($value)
 * @method static Builder|Lesson whereQuota($value)
 * @method static Builder|Lesson whereSubjectId($value)
 * @method static Builder|Lesson whereTenantId($value)
 * @method static Builder|Lesson whereUpdatedAt($value)
 * @method static Builder|Lesson withTrashed()
 * @method static Builder|Lesson withoutTrashed()
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
