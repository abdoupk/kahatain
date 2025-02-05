<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
