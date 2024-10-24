<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Committee extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }

    public function searchableAs(): string
    {
        return 'committees';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount('members');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'members_count' => (int) $this->members_count,
            'tenant_id' => $this->tenant_id,
            'description' => $this->description,
            'created_at' => strtotime($this->created_at),
        ];
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(CommitteeUser::class);
    }
}
