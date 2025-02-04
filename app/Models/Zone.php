<?php

namespace App\Models;

use Database\Factories\ZoneFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $created_by
 * @property string|null $deleted_by
 * @property-read User $creator
 * @property-read Collection<int, Family> $families
 * @property-read int|null $families_count
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read Tenant $tenant
 *
 * @method static ZoneFactory factory($count = null, $state = [])
 * @method static Builder|Zone newModelQuery()
 * @method static Builder|Zone newQuery()
 * @method static Builder|Zone onlyTrashed()
 * @method static Builder|Zone query()
 * @method static Builder|Zone whereCreatedAt($value)
 * @method static Builder|Zone whereCreatedBy($value)
 * @method static Builder|Zone whereDeletedAt($value)
 * @method static Builder|Zone whereDeletedBy($value)
 * @method static Builder|Zone whereDescription($value)
 * @method static Builder|Zone whereId($value)
 * @method static Builder|Zone whereName($value)
 * @method static Builder|Zone whereTenantId($value)
 * @method static Builder|Zone whereUpdatedAt($value)
 * @method static Builder|Zone withTrashed()
 * @method static Builder|Zone withoutTrashed()
 *
 * @property array|null $geom
 *
 * @method static Builder<static>|Zone whereGeom($value)
 *
 * @property-read \App\Models\TFactory|null $use_factory
 *
 * @mixin Eloquent
 */
class Zone extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $table = 'zones';

    protected $fillable = ['name', 'description', 'geom', 'created_by', 'deleted_by'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }
        });

        static::softDeleted(function ($model): void {
            if (auth()->id()) {
                $model->deleted_by = auth()->id();

                $model->save();
            }
        });
    }

    public function searchableAs(): string
    {
        return 'zones';
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount(['families', 'members']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'families_count' => (int) $this->families_count,
            'members_count' => (int) $this->members_count,
            'tenant_id' => $this->tenant_id,
            'description' => $this->description,
            'created_at' => strtotime($this->created_at),
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'geom' => 'json',
        ];
    }
}
