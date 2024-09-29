<?php

namespace App\Models;

use Database\Factories\VocationalTrainingAchievementFactory;
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
 * @property string $tenant_id
 * @property string $orphan_id
 * @property string|null $note
 * @property int $year
 * @property int $vocational_training_id
 * @property string|null $institute
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Orphan $orphan
 * @property-read Tenant $tenant
 * @property-read VocationalTraining|null $vocationalTraining
 * @method static VocationalTrainingAchievementFactory factory($count = null, $state = [])
 * @method static Builder|VocationalTrainingAchievement newModelQuery()
 * @method static Builder|VocationalTrainingAchievement newQuery()
 * @method static Builder|VocationalTrainingAchievement onlyTrashed()
 * @method static Builder|VocationalTrainingAchievement query()
 * @method static Builder|VocationalTrainingAchievement whereCreatedAt($value)
 * @method static Builder|VocationalTrainingAchievement whereDeletedAt($value)
 * @method static Builder|VocationalTrainingAchievement whereId($value)
 * @method static Builder|VocationalTrainingAchievement whereInstitute($value)
 * @method static Builder|VocationalTrainingAchievement whereNote($value)
 * @method static Builder|VocationalTrainingAchievement whereOrphanId($value)
 * @method static Builder|VocationalTrainingAchievement whereTenantId($value)
 * @method static Builder|VocationalTrainingAchievement whereUpdatedAt($value)
 * @method static Builder|VocationalTrainingAchievement whereVocationalTrainingId($value)
 * @method static Builder|VocationalTrainingAchievement whereYear($value)
 * @method static Builder|VocationalTrainingAchievement withTrashed()
 * @method static Builder|VocationalTrainingAchievement withoutTrashed()
 * @mixin Eloquent
 */
class VocationalTrainingAchievement extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'orphan_id',
        'note',
        'year',
        'vocational_training_id',
        'institute',
    ];

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }

    public function vocationalTraining(): BelongsTo
    {
        return $this->belongsTo(VocationalTraining::class);
    }
}
