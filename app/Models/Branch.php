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

class Branch extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = ['name', 'president_id', 'city_id', 'created_at', 'created_by', 'deleted_by'];

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

    public function president(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function searchableAs(): string
    {
        return 'branches';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['city', 'president'])->loadCount(['families', 'members']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'created_at' => strtotime($this->created_at),
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'families_count' => $this->families_count,
            'members_count' => $this->members_count,
            'city' => [
                'id' => $this->city_id,
                'ar_name' => $this->city->getFullName(),
                'latin_name' => $this->city->getFullName('fr'),
            ],
            'president' => [
                'id' => $this->president_id,
                'name' => $this->president->getName(),
            ],
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}
