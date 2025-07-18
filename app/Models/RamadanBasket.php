<?php

namespace App\Models;

use Database\Factories\RamadanBasketFactory;
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
 * @property int $qty_for_family
 * @property bool $status
 * @property string $inventory_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Inventory $inventory
 * @property-read Tenant $tenant
 *
 * @method static RamadanBasketFactory factory($count = null, $state = [])
 * @method static Builder<static>|RamadanBasket newModelQuery()
 * @method static Builder<static>|RamadanBasket newQuery()
 * @method static Builder<static>|RamadanBasket query()
 * @method static Builder<static>|RamadanBasket whereCreatedAt($value)
 * @method static Builder<static>|RamadanBasket whereId($value)
 * @method static Builder<static>|RamadanBasket whereInventoryId($value)
 * @method static Builder<static>|RamadanBasket whereQtyForFamily($value)
 * @method static Builder<static>|RamadanBasket whereStatus($value)
 * @method static Builder<static>|RamadanBasket whereTenantId($value)
 * @method static Builder<static>|RamadanBasket whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class RamadanBasket extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'qty_for_family',
        'status',
        'inventory_id',
        'tenant_id',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
