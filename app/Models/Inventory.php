<?php

namespace App\Models;

use Database\Factories\InventoryFactory;
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
 * @property string $name
 * @property int $qty
 * @property string $unit
 * @property string|null $type
 * @property string|null $note
 * @property int|null $qty_for_family
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property string $created_by
 * @property string $deleted_by
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $creator
 * @property-read Tenant $tenant
 *
 * @method static InventoryFactory factory($count = null, $state = [])
 * @method static Builder|Inventory newModelQuery()
 * @method static Builder|Inventory newQuery()
 * @method static Builder|Inventory onlyTrashed()
 * @method static Builder|Inventory query()
 * @method static Builder|Inventory whereCreatedAt($value)
 * @method static Builder|Inventory whereCreatedBy($value)
 * @method static Builder|Inventory whereDeletedAt($value)
 * @method static Builder|Inventory whereDeletedBy($value)
 * @method static Builder|Inventory whereId($value)
 * @method static Builder|Inventory whereName($value)
 * @method static Builder|Inventory whereNote($value)
 * @method static Builder|Inventory whereQty($value)
 * @method static Builder|Inventory whereQtyForFamily($value)
 * @method static Builder|Inventory whereTenantId($value)
 * @method static Builder|Inventory whereType($value)
 * @method static Builder|Inventory whereUnit($value)
 * @method static Builder|Inventory whereUpdatedAt($value)
 * @method static Builder|Inventory withTrashed()
 * @method static Builder|Inventory withoutTrashed()
 *
 * @property-read Collection<int, MonthlyBasket> $monthlyBasket
 * @property-read int|null $monthly_basket_count
 * @property-read Collection<int, RamadanBasket> $ramadanBasket
 * @property-read int|null $ramadan_basket_count
 *
 * @mixin Eloquent
 */
class Inventory extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'qty',
        'unit',
        'note',
        'type',
        'id',
        'qty_for_family',
        'created_by',
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

    public function searchableAs(): string
    {
        return 'inventory';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'unit' => $this->unit,
            'note' => $this->note,
            'tenant_id' => $this->tenant_id,
            'created_by' => [
                'id' => $this->creator?->id,
                'name' => $this->creator?->getName(),
            ],
            'created_at' => strtotime($this->created_at),
            'type' => $this->type,
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ramadanBasket(): HasMany
    {
        return $this->hasMany(RamadanBasket::class);
    }

    public function monthlyBasket(): HasMany
    {
        return $this->hasMany(MonthlyBasket::class);
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
        ];
    }
}
