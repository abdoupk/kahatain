<?php

namespace App\Models;

use Database\Factories\FinanceFactory;
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
 * @property float $amount
 * @property string|null $description
 * @property Carbon $date
 * @property string $tenant_id
 * @property string $specification
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $created_by
 * @property string|null $received_by
 * @property string|null $deleted_by
 * @property-read User $creator
 * @property-read User|null $receiver
 * @property-read Tenant $tenant
 *
 * @method static FinanceFactory factory($count = null, $state = [])
 * @method static Builder<static>|Finance newModelQuery()
 * @method static Builder<static>|Finance newQuery()
 * @method static Builder<static>|Finance onlyTrashed()
 * @method static Builder<static>|Finance query()
 * @method static Builder<static>|Finance whereAmount($value)
 * @method static Builder<static>|Finance whereCreatedAt($value)
 * @method static Builder<static>|Finance whereCreatedBy($value)
 * @method static Builder<static>|Finance whereDate($value)
 * @method static Builder<static>|Finance whereDeletedAt($value)
 * @method static Builder<static>|Finance whereDeletedBy($value)
 * @method static Builder<static>|Finance whereDescription($value)
 * @method static Builder<static>|Finance whereId($value)
 * @method static Builder<static>|Finance whereReceivedBy($value)
 * @method static Builder<static>|Finance whereSpecification($value)
 * @method static Builder<static>|Finance whereTenantId($value)
 * @method static Builder<static>|Finance whereUpdatedAt($value)
 * @method static Builder<static>|Finance withTrashed()
 * @method static Builder<static>|Finance withoutTrashed()
 *
 * @mixin Eloquent
 */
class Finance extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
        'description',
        'date',
        'specification',
        'created_by',
        'received_by',
        'deleted_by',
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function searchableAs(): string
    {
        return 'finances';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['creator', 'receiver']);
    }

    public function toSearchableArray(): array
    {
        return [
            'amount' => $this->amount,
            'name' => $this->name,
            'description' => $this->description,
            'date' => strtotime($this->date),
            'specification' => [
                'ar' => __($this->specification, locale: 'ar'),
                'en' => __($this->specification, locale: 'en'),
                'fr' => __($this->specification, locale: 'fr'),
            ],
            'creator' => [
                'id' => $this->creator?->id,
                'name' => $this->creator?->getName(),
            ],
            'receiver' => [
                'id' => $this->receiver?->id,
                'name' => $this->receiver?->getName(),
            ],
            'finance_type' => $this->amount > 0 ? 'income' : 'expense',
            'abs_amount' => abs($this->amount),
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'created_by' => 'string',
        ];
    }
}
