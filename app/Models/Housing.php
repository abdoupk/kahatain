<?php

namespace App\Models;

use Database\Factories\HousingFactory;
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
 * @property string $name
 * @property string|null $value
 * @property string|null $housing_receipt_number
 * @property int|null $number_of_rooms
 * @property string|null $other_properties
 * @property string $family_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Family $family
 * @property-read Tenant $tenant
 *
 * @method static HousingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Housing newModelQuery()
 * @method static Builder<static>|Housing newQuery()
 * @method static Builder<static>|Housing query()
 * @method static Builder<static>|Housing whereCreatedAt($value)
 * @method static Builder<static>|Housing whereFamilyId($value)
 * @method static Builder<static>|Housing whereHousingReceiptNumber($value)
 * @method static Builder<static>|Housing whereId($value)
 * @method static Builder<static>|Housing whereName($value)
 * @method static Builder<static>|Housing whereNumberOfRooms($value)
 * @method static Builder<static>|Housing whereOtherProperties($value)
 * @method static Builder<static>|Housing whereTenantId($value)
 * @method static Builder<static>|Housing whereUpdatedAt($value)
 * @method static Builder<static>|Housing whereValue($value)
 *
 * @mixin Eloquent
 */
class Housing extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'value',
        'family_id',
        'housing_receipt_number',
        'number_of_rooms',
        'other_properties',
        'tenant_id',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
