<?php

namespace App\Models;

use Database\Factories\BabyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property int|null $baby_milk_quantity
 * @property string|null $baby_milk_type
 * @property int|null $diapers_quantity
 * @property string|null $diapers_type
 * @property string $orphan_id
 * @property string $family_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Inventory|null $babyMilk
 * @property-read Inventory|null $diapers
 * @property-read Orphan $orphan
 * @property-read Tenant $tenant
 *
 * @method static BabyFactory factory($count = null, $state = [])
 * @method static Builder|Baby newModelQuery()
 * @method static Builder|Baby newQuery()
 * @method static Builder|Baby onlyTrashed()
 * @method static Builder|Baby query()
 * @method static Builder|Baby whereBabyMilkQuantity($value)
 * @method static Builder|Baby whereBabyMilkType($value)
 * @method static Builder|Baby whereCreatedAt($value)
 * @method static Builder|Baby whereDeletedAt($value)
 * @method static Builder|Baby whereDiapersQuantity($value)
 * @method static Builder|Baby whereDiapersType($value)
 * @method static Builder|Baby whereFamilyId($value)
 * @method static Builder|Baby whereId($value)
 * @method static Builder|Baby whereOrphanId($value)
 * @method static Builder|Baby whereTenantId($value)
 * @method static Builder|Baby whereUpdatedAt($value)
 * @method static Builder|Baby withTrashed()
 * @method static Builder|Baby withoutTrashed()
 *
 * @mixin Eloquent
 */
class Baby extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'baby_milk_quantity',
        'baby_milk_type',
        'diapers_quantity',
        'diapers_type',
        'orphan_id',
        'family_id',
    ];

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }

    public function diapers(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'diapers_type', 'id');
    }

    public function babyMilk(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'baby_milk_type', 'id');
    }

    public function shouldBeSearchable(): bool
    {
        return $this->orphan->birth_date->age < 2;
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'baby_milk_quantity' => $this->baby_milk_quantity,
            'baby_milk_type' => $this->baby_milk_type,
            'diapers_quantity' => $this->diapers_quantity,
            'diapers_type' => $this->diapers_type,
            'orphan' => [
                'id' => $this->orphan_id,
                'name' => $this->orphan->getName(),
                'birth_date' => strtotime($this->orphan->birth_date),
                'readable_birth_date' => $this->orphan->birth_date,
                'gender' => $this->orphan->gender,
                'health_status' => $this->orphan->health_status,
            ],
            'family' => [
                'id' => $this->family_id,
                'name' => $this->orphan->family->name,
            ],
            'sponsor' => [
                'id' => $this->orphan->sponsor?->id,
                'name' => $this->orphan->sponsor?->getName(),
            ],
            'address' => [
                'address' => $this->orphan->family->address,
                'zone' => [
                    'id' => $this->orphan->family->zone?->id,
                    'name' => $this->orphan->family->zone?->name,
                ],
            ],
            'created_at' => strtotime($this->created_at),
            'tenant_id' => $this->tenant_id,
        ];
    }

    public function getName(): string
    {
        return $this->orphan->getName();
    }

    public function searchableAs(): string
    {
        return 'babies';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['orphan.family.zone', 'orphan.sponsor']);
    }

    public function archives(): MorphToMany
    {
        return $this->morphToMany(Archive::class, 'archiveable');
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'orphan_id' => 'string',
        ];
    }
}
