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
 *
 *
 * @property string $id
 * @property string $television
 * @property string $refrigerator
 * @property string $fireplace
 * @property string $washing_machine
 * @property string $water_heater
 * @property string $oven
 * @property string $wardrobe
 * @property string $cupboard
 * @property string $covers
 * @property string $mattresses
 * @property string $other_furnishings
 * @property string $family_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Family $family
 * @property-read Tenant $tenant
 * @method static FurnishingFactory factory($count = null, $state = [])
 * @method static Builder|Furnishing newModelQuery()
 * @method static Builder|Furnishing newQuery()
 * @method static Builder|Furnishing query()
 * @method static Builder|Furnishing whereCovers($value)
 * @method static Builder|Furnishing whereCreatedAt($value)
 * @method static Builder|Furnishing whereCupboard($value)
 * @method static Builder|Furnishing whereFamilyId($value)
 * @method static Builder|Furnishing whereFireplace($value)
 * @method static Builder|Furnishing whereId($value)
 * @method static Builder|Furnishing whereMattresses($value)
 * @method static Builder|Furnishing whereOtherFurnishings($value)
 * @method static Builder|Furnishing whereOven($value)
 * @method static Builder|Furnishing whereRefrigerator($value)
 * @method static Builder|Furnishing whereTelevision($value)
 * @method static Builder|Furnishing whereTenantId($value)
 * @method static Builder|Furnishing whereUpdatedAt($value)
 * @method static Builder|Furnishing whereWardrobe($value)
 * @method static Builder|Furnishing whereWashingMachine($value)
 * @method static Builder|Furnishing whereWaterHeater($value)
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
}
