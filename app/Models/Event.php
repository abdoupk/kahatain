<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Event extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'until',
        'frequency',
        'interval',
        'lesson_id',
        'start_date',
        'end_date',
        'color',
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

    public function school(): BelongsTo
    {
        return $this->belongsTo(PrivateSchool::class);
    }

    public function orphans(): HasManyThrough
    {
        return $this->hasManyThrough(
            Orphan::class,
            EventOccurrence::class,
            'event_id',       // Foreign key in event_occurrences
            'id',             // Primary key in orphans table
            'id',             // Primary key in events table
            'id'              // Primary key in event_occurrences table
        )->with('sponsor:id,first_name,last_name,phone_number');
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'school_id' => 'string',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}
