<?php

namespace App\Models;

use Database\Factories\CommitteeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $created_by
 * @property string|null $deleted_by
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $creator
 * @property-read CommitteeUser|null $pivot
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read Tenant|null $tenant
 *
 * @method static CommitteeFactory factory($count = null, $state = [])
 * @method static Builder<static>|Committee newModelQuery()
 * @method static Builder<static>|Committee newQuery()
 * @method static Builder<static>|Committee onlyTrashed()
 * @method static Builder<static>|Committee query()
 * @method static Builder<static>|Committee whereCreatedAt($value)
 * @method static Builder<static>|Committee whereCreatedBy($value)
 * @method static Builder<static>|Committee whereDeletedAt($value)
 * @method static Builder<static>|Committee whereDeletedBy($value)
 * @method static Builder<static>|Committee whereDescription($value)
 * @method static Builder<static>|Committee whereId($value)
 * @method static Builder<static>|Committee whereName($value)
 * @method static Builder<static>|Committee whereTenantId($value)
 * @method static Builder<static>|Committee whereUpdatedAt($value)
 * @method static Builder<static>|Committee withTrashed()
 * @method static Builder<static>|Committee withoutTrashed()
 *
 * @mixin Eloquent
 */
class Committee extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'deleted_by',
        'tenant_id',
    ];

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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function searchableAs(): string
    {
        return 'committees';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount('members');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'members_count' => (int) $this->members_count,
            'tenant_id' => $this->tenant_id,
            'description' => $this->description,
            'created_at' => strtotime($this->created_at),
            'readable_created_at' => $this->created_at,
        ];
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(CommitteeUser::class);
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
