<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
