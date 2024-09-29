<?php

namespace App\Models;

use Database\Factories\CollegeAchievementFactory;
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
 *
 *
 * @property string $id
 * @property string $orphan_id
 * @property float|null $first_semester
 * @property float|null $second_semester
 * @property string $speciality
 * @property int $year
 * @property string|null $university
 * @property string|null $note
 * @property float|null $average
 * @property string $tenant_id
 * @property int $academic_level_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Orphan $orphan
 * @property-read Tenant $tenant
 * @method static CollegeAchievementFactory factory($count = null, $state = [])
 * @method static Builder|CollegeAchievement newModelQuery()
 * @method static Builder|CollegeAchievement newQuery()
 * @method static Builder|CollegeAchievement onlyTrashed()
 * @method static Builder|CollegeAchievement query()
 * @method static Builder|CollegeAchievement whereAcademicLevelId($value)
 * @method static Builder|CollegeAchievement whereAverage($value)
 * @method static Builder|CollegeAchievement whereCreatedAt($value)
 * @method static Builder|CollegeAchievement whereDeletedAt($value)
 * @method static Builder|CollegeAchievement whereFirstSemester($value)
 * @method static Builder|CollegeAchievement whereId($value)
 * @method static Builder|CollegeAchievement whereNote($value)
 * @method static Builder|CollegeAchievement whereOrphanId($value)
 * @method static Builder|CollegeAchievement whereSecondSemester($value)
 * @method static Builder|CollegeAchievement whereSpeciality($value)
 * @method static Builder|CollegeAchievement whereTenantId($value)
 * @method static Builder|CollegeAchievement whereUniversity($value)
 * @method static Builder|CollegeAchievement whereUpdatedAt($value)
 * @method static Builder|CollegeAchievement whereYear($value)
 * @method static Builder|CollegeAchievement withTrashed()
 * @method static Builder|CollegeAchievement withoutTrashed()
 * @mixin Eloquent
 */
class CollegeAchievement extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'orphan_id',
        'first_semester',
        'second_semester',
        'speciality',
        'note',
        'university',
        'academic_level_id',
        'year',
        'average',
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
