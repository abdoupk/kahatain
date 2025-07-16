<?php

namespace App\Models;

use Database\Factories\MonthlyBasketFactory;
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
 * @property string $tenant_id
 * @property string $inventory_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Inventory $inventory
 * @property-read Tenant $tenant
 *
 * @method static MonthlyBasketFactory factory($count = null, $state = [])
 * @method static Builder<static>|MonthlyBasket newModelQuery()
 * @method static Builder<static>|MonthlyBasket newQuery()
 * @method static Builder<static>|MonthlyBasket query()
 * @method static Builder<static>|MonthlyBasket whereCreatedAt($value)
 * @method static Builder<static>|MonthlyBasket whereId($value)
 * @method static Builder<static>|MonthlyBasket whereInventoryId($value)
 * @method static Builder<static>|MonthlyBasket whereQtyForFamily($value)
 * @method static Builder<static>|MonthlyBasket whereStatus($value)
 * @method static Builder<static>|MonthlyBasket whereTenantId($value)
 * @method static Builder<static>|MonthlyBasket whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class MonthlyBasket extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'inventory_id',
        'qty_for_family',
        'status',
        'tenant_id',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
