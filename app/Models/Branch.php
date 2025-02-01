<?php

namespace App\Models;

use Database\Factories\BranchFactory;
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
 * @property string $tenant_id
 * @property int $city_id
 * @property string $president_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $created_by
 * @property string|null $deleted_by
 * @property-read City $city
 * @property-read User $creator
 * @property-read Collection<int, Family> $families
 * @property-read int|null $families_count
 * @property-read User $president
 * @property-read Tenant $tenant
 *
 * @method static BranchFactory factory($count = null, $state = [])
 * @method static Builder|Branch newModelQuery()
 * @method static Builder|Branch newQuery()
 * @method static Builder|Branch onlyTrashed()
 * @method static Builder|Branch query()
 * @method static Builder|Branch whereCityId($value)
 * @method static Builder|Branch whereCreatedAt($value)
 * @method static Builder|Branch whereCreatedBy($value)
 * @method static Builder|Branch whereDeletedAt($value)
 * @method static Builder|Branch whereDeletedBy($value)
 * @method static Builder|Branch whereId($value)
 * @method static Builder|Branch whereName($value)
 * @method static Builder|Branch wherePresidentId($value)
 * @method static Builder|Branch whereTenantId($value)
 * @method static Builder|Branch whereUpdatedAt($value)
 * @method static Builder|Branch withTrashed()
 * @method static Builder|Branch withoutTrashed()
 *
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 *
 * @mixin Eloquent
 */
class Branch extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = ['name', 'president_id', 'city_id', 'created_at', 'created_by', 'deleted_by'];

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

    public function president(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function searchableAs(): string
    {
        return 'branches';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['city', 'president'])->loadCount(['families', 'members']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'created_at' => strtotime($this->created_at),
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'families_count' => $this->families_count,
            'members_count' => $this->members_count,
            'city' => [
                'id' => $this->city_id,
                'ar_name' => $this->city->getFullName(),
                'latin_name' => $this->city->getFullName('fr'),
            ],
            'president' => [
                'id' => $this->president_id,
                'name' => $this->president->getName(),
            ],
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}
