<?php

namespace App\Models;

use Database\Factories\AcademicAchievementFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property int|null $academic_level_id
 * @property int|null $academic_year
 * @property float|null $first_trimester
 * @property float|null $second_trimester
 * @property float|null $third_trimester
 * @property float|null $average
 * @property string|null $note
 * @property string $orphan_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Orphan $orphan
 * @property-read Tenant $tenant
 *
 * @method static AcademicAchievementFactory factory($count = null, $state = [])
 * @method static Builder|AcademicAchievement newModelQuery()
 * @method static Builder|AcademicAchievement newQuery()
 * @method static Builder|AcademicAchievement onlyTrashed()
 * @method static Builder|AcademicAchievement query()
 * @method static Builder|AcademicAchievement whereAcademicLevelId($value)
 * @method static Builder|AcademicAchievement whereAcademicYear($value)
 * @method static Builder|AcademicAchievement whereAverage($value)
 * @method static Builder|AcademicAchievement whereCreatedAt($value)
 * @method static Builder|AcademicAchievement whereDeletedAt($value)
 * @method static Builder|AcademicAchievement whereFirstTrimester($value)
 * @method static Builder|AcademicAchievement whereId($value)
 * @method static Builder|AcademicAchievement whereNote($value)
 * @method static Builder|AcademicAchievement whereOrphanId($value)
 * @method static Builder|AcademicAchievement whereSecondTrimester($value)
 * @method static Builder|AcademicAchievement whereTenantId($value)
 * @method static Builder|AcademicAchievement whereThirdTrimester($value)
 * @method static Builder|AcademicAchievement whereUpdatedAt($value)
 * @method static Builder|AcademicAchievement withTrashed()
 * @method static Builder|AcademicAchievement withoutTrashed()
 *
 * @mixin Eloquent
 */
class AcademicAchievement extends Model
{
    use BelongsToTenant, HasFactory, Hasuuids, SoftDeletes;

    protected $fillable = [
        'orphan_id',
        'academic_level_id',
        'academic_year',
        'first_trimester',
        'second_trimester',
        'third_trimester',
        'average',
        'first_semester',
        'second_semester',
        'note',
    ];

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    protected function casts(): array
    {
        return [
            'orphan_id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}
