<?php

namespace App\Models;

use Database\Factories\BenefactorFactory;
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
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property string|null $address
 * @property array|null $location
 * @property string $created_by
 * @property string|null $deleted_by
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $creator
 * @property-read Collection<int, Sponsorship> $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read Tenant|null $tenant
 *
 * @method static BenefactorFactory factory($count = null, $state = [])
 * @method static Builder<static>|Benefactor newModelQuery()
 * @method static Builder<static>|Benefactor newQuery()
 * @method static Builder<static>|Benefactor onlyTrashed()
 * @method static Builder<static>|Benefactor query()
 * @method static Builder<static>|Benefactor whereAddress($value)
 * @method static Builder<static>|Benefactor whereCreatedAt($value)
 * @method static Builder<static>|Benefactor whereCreatedBy($value)
 * @method static Builder<static>|Benefactor whereDeletedAt($value)
 * @method static Builder<static>|Benefactor whereDeletedBy($value)
 * @method static Builder<static>|Benefactor whereFirstName($value)
 * @method static Builder<static>|Benefactor whereId($value)
 * @method static Builder<static>|Benefactor whereLastName($value)
 * @method static Builder<static>|Benefactor whereLocation($value)
 * @method static Builder<static>|Benefactor wherePhone($value)
 * @method static Builder<static>|Benefactor whereTenantId($value)
 * @method static Builder<static>|Benefactor whereUpdatedAt($value)
 * @method static Builder<static>|Benefactor withTrashed()
 * @method static Builder<static>|Benefactor withoutTrashed()
 *
 * @property-read \App\Models\TFactory|null $use_factory
 *
 * @mixin Eloquent
 */
class Benefactor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'location',
        'address',
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

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount(['sponsorships']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tenant_id' => $this->tenant_id,
            'sponsorships_count' => $this->sponsorships_count,
            'created_at' => strtotime($this->created_at),
            'readable_created_at' => $this->created_at,
            'name' => $this->getName(),
        ];
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function searchableAs(): string
    {
        return 'benefactors';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    protected function casts(): array
    {
        return [
            'location' => 'array',
        ];
    }
}
