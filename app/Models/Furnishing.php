<?php

namespace App\Models;

use Database\Factories\FurnishingFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property array<array-key, mixed>|null $television
 * @property array<array-key, mixed>|null $refrigerator
 * @property array<array-key, mixed>|null $fireplace
 * @property array<array-key, mixed>|null $washing_machine
 * @property array<array-key, mixed>|null $water_heater
 * @property array<array-key, mixed>|null $oven
 * @property array<array-key, mixed>|null $wardrobe
 * @property array<array-key, mixed>|null $cupboard
 * @property array<array-key, mixed>|null $covers
 * @property array<array-key, mixed>|null $mattresses
 * @property array<array-key, mixed>|null $other_furnishings
 * @property string $family_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Family $family
 * @property-read Tenant $tenant
 *
 * @method static FurnishingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Furnishing newModelQuery()
 * @method static Builder<static>|Furnishing newQuery()
 * @method static Builder<static>|Furnishing query()
 * @method static Builder<static>|Furnishing whereCovers($value)
 * @method static Builder<static>|Furnishing whereCreatedAt($value)
 * @method static Builder<static>|Furnishing whereCupboard($value)
 * @method static Builder<static>|Furnishing whereFamilyId($value)
 * @method static Builder<static>|Furnishing whereFireplace($value)
 * @method static Builder<static>|Furnishing whereId($value)
 * @method static Builder<static>|Furnishing whereMattresses($value)
 * @method static Builder<static>|Furnishing whereOtherFurnishings($value)
 * @method static Builder<static>|Furnishing whereOven($value)
 * @method static Builder<static>|Furnishing whereRefrigerator($value)
 * @method static Builder<static>|Furnishing whereTelevision($value)
 * @method static Builder<static>|Furnishing whereTenantId($value)
 * @method static Builder<static>|Furnishing whereUpdatedAt($value)
 * @method static Builder<static>|Furnishing whereWardrobe($value)
 * @method static Builder<static>|Furnishing whereWashingMachine($value)
 * @method static Builder<static>|Furnishing whereWaterHeater($value)
 *
 * @mixin Eloquent
 */
class Furnishing extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'television',
        'refrigerator',
        'fireplace',
        'washing_machine',
        'water_heater',
        'oven',
        'wardrobe',
        'cupboard',
        'covers',
        'mattresses',
        'other_furnishings',
        'family_id',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    protected function casts(): array
    {
        return [
            'television' => 'array',
            'refrigerator' => 'array',
            'fireplace' => 'array',
            'washing_machine' => 'array',
            'water_heater' => 'array',
            'oven' => 'array',
            'wardrobe' => 'array',
            'cupboard' => 'array',
            'covers' => 'array',
            'mattresses' => 'array',
            'other_furnishings' => 'array',
        ];
    }
}
