<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Benefactor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'location',
        'address',
        'created_by',
        'deleted_by',
        'tenant_id',
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

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount(['sponsorships']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tenant_id' => $this->tenant_id,
            'sponsorships_count' => $this->sponsorships_count,
            'created_at' => $this->created_at,
            'name' => $this->getName(),
        ];
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function searchableAs(): string
    {
        return 'benefactors';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    protected function casts(): array
    {
        return [
            'location' => 'array',
        ];
    }
}
