<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
        return $this->orphan->birth_date->age <= 2;
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
