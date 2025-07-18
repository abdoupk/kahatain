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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $name
 * @property int|null $qty
 * @property string|null $unit
 * @property string|null $type
 * @property string|null $note
 * @property string $created_by
 * @property string|null $deleted_by
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $creator
 * @property-read Tenant $tenant
 *
 * @method static InventoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Inventory newModelQuery()
 * @method static Builder<static>|Inventory newQuery()
 * @method static Builder<static>|Inventory onlyTrashed()
 * @method static Builder<static>|Inventory query()
 * @method static Builder<static>|Inventory whereCreatedAt($value)
 * @method static Builder<static>|Inventory whereCreatedBy($value)
 * @method static Builder<static>|Inventory whereDeletedAt($value)
 * @method static Builder<static>|Inventory whereDeletedBy($value)
 * @method static Builder<static>|Inventory whereId($value)
 * @method static Builder<static>|Inventory whereName($value)
 * @method static Builder<static>|Inventory whereNote($value)
 * @method static Builder<static>|Inventory whereQty($value)
 * @method static Builder<static>|Inventory whereTenantId($value)
 * @method static Builder<static>|Inventory whereType($value)
 * @method static Builder<static>|Inventory whereUnit($value)
 * @method static Builder<static>|Inventory whereUpdatedAt($value)
 * @method static Builder<static>|Inventory withTrashed()
 * @method static Builder<static>|Inventory withoutTrashed()
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
            'qty' => $this->qty ?? 0,
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

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['creator']);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
        ];
    }
}
