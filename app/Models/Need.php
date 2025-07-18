<?php

namespace App\Models;

use Database\Factories\NeedFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $demand
 * @property string $subject
 * @property string $status
 * @property string $needable_type
 * @property string $needable_id
 * @property string $tenant_id
 * @property string|null $note
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read User|null $creator
 * @property-read Model|Eloquent $needable
 * @property-read Tenant $tenant
 *
 * @method static NeedFactory factory($count = null, $state = [])
 * @method static Builder<static>|Need newModelQuery()
 * @method static Builder<static>|Need newQuery()
 * @method static Builder<static>|Need onlyTrashed()
 * @method static Builder<static>|Need query()
 * @method static Builder<static>|Need whereCreatedAt($value)
 * @method static Builder<static>|Need whereCreatedBy($value)
 * @method static Builder<static>|Need whereDeletedAt($value)
 * @method static Builder<static>|Need whereDeletedBy($value)
 * @method static Builder<static>|Need whereDemand($value)
 * @method static Builder<static>|Need whereId($value)
 * @method static Builder<static>|Need whereNeedableId($value)
 * @method static Builder<static>|Need whereNeedableType($value)
 * @method static Builder<static>|Need whereNote($value)
 * @method static Builder<static>|Need whereStatus($value)
 * @method static Builder<static>|Need whereSubject($value)
 * @method static Builder<static>|Need whereTenantId($value)
 * @method static Builder<static>|Need whereUpdatedAt($value)
 * @method static Builder<static>|Need withTrashed()
 * @method static Builder<static>|Need withoutTrashed()
 *
 * @mixin Eloquent
 */
class Need extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'demand',
        'status',
        'subject',
        'note',
        'created_by',
        'deleted_by',
        'needable_id',
        'needable_type',
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

    public function needable(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function searchableAs(): string
    {
        return 'needs';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['needable.family.branch', 'needable.family.zone']);
    }

    public function toSearchableArray(): array
    {
        /* @var Orphan | Sponsor $needable */
        $needable = $this->needable;

        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'demand' => $this->demand,
            'status' => $this->status,
            'needable' => [
                'id' => $this->needable_id,
                'name' => $needable?->getName(),
                'type' => $this->needable_type,
                'income_rate' => (float) $needable->family->income_rate,
            ],
            'branch' => [
                'id' => $needable->family->branch?->id,
                'name' => $needable->family->branch?->name,
            ],
            'zone' => [
                'id' => $needable->family->zone?->id,
                'name' => $needable->family->zone?->name,
            ],
            'note' => $this->note,
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }
}
