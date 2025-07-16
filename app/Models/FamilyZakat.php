<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property float $amount
 * @property string $zakat_id
 * @property string $family_id
 * @property string $tenant_id
 * @property-read Collection<int, Family> $families
 * @property-read int|null $families_count
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|FamilyZakat newModelQuery()
 * @method static Builder<static>|FamilyZakat newQuery()
 * @method static Builder<static>|FamilyZakat query()
 * @method static Builder<static>|FamilyZakat whereAmount($value)
 * @method static Builder<static>|FamilyZakat whereFamilyId($value)
 * @method static Builder<static>|FamilyZakat whereId($value)
 * @method static Builder<static>|FamilyZakat whereTenantId($value)
 * @method static Builder<static>|FamilyZakat whereZakatId($value)
 *
 * @mixin Eloquent
 */
class FamilyZakat extends Model
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'amount',
        'family_id',
        'zakat_id',
    ];

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class);
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'family_id' => 'string',
            'zakat_id' => 'string',
        ];
    }
}
