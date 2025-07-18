<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $title
 * @property string $lesson_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string|null $frequency
 * @property int|null $interval
 * @property string|null $until
 * @property string|null $color
 * @property string $tenant_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $created_by
 * @property string|null $deleted_by
 * @property-read User $creator
 * @property-read Collection<int, EventOccurrence> $occurrences
 * @property-read int|null $occurrences_count
 * @property-read PrivateSchool|null $school
 * @property-read Subject|null $subject
 * @property-read Tenant $tenant
 *
 * @method static EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event onlyTrashed()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereColor($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatedBy($value)
 * @method static Builder<static>|Event whereDeletedAt($value)
 * @method static Builder<static>|Event whereDeletedBy($value)
 * @method static Builder<static>|Event whereEndDate($value)
 * @method static Builder<static>|Event whereFrequency($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereInterval($value)
 * @method static Builder<static>|Event whereLessonId($value)
 * @method static Builder<static>|Event whereStartDate($value)
 * @method static Builder<static>|Event whereTenantId($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereUntil($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event withTrashed()
 * @method static Builder<static>|Event withoutTrashed()
 *
 * @mixin Eloquent
 */
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
