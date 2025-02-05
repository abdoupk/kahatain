<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PrivateSchool extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'created_by',
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

    public function searchableAs(): string
    {
        return 'private_schools';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load('lessons');
    }

    public function toSearchableArray(): array
    {
        return [
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'quota' => $this->lessons->sum('quota'),
            'created_at' => strtotime($this->created_at),
        ];
    }

    public function subjects()
    {
        return $this->lessons()->with('subject');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'private_school_id', 'id');
    }

    public function eventsWithOrphans(): HasManyThrough
    {
        return $this->hasManyThrough(EventOccurrence::class, Lesson::class, 'private_school_id', 'lesson_id', 'id', 'id')->with('orphans:id,first_name,last_name,sponsor_id', 'orphans.sponsor:id,first_name,last_name,phone_number');
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
