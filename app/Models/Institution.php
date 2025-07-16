<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $institutionable_type
 * @property int $institutionable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $institutionable
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|Institution newModelQuery()
 * @method static Builder<static>|Institution newQuery()
 * @method static Builder<static>|Institution query()
 * @method static Builder<static>|Institution whereCreatedAt($value)
 * @method static Builder<static>|Institution whereId($value)
 * @method static Builder<static>|Institution whereInstitutionableId($value)
 * @method static Builder<static>|Institution whereInstitutionableType($value)
 * @method static Builder<static>|Institution whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Institution extends Model
{
    use BelongsToTenant, HasUuids;

    protected $fillable = ['institutionable_id', 'institutionable_type'];

    public function institutionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }
}
