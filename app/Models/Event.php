<?php

namespace App\Models;

use Carbon\Carbon;
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
use Recurr\Exception\InvalidArgument;
use Recurr\Rule;
use Recurr\Transformer\TextTransformer;
use Recurr\Transformer\Translator;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Str;

/**
 * @property string $id
 * @property string $title
 * @property string $lesson_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string|null $frequency
 * @property int|null $interval
 * @property string|null $until
 * @property string|null $color
 * @property string $tenant_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event onlyTrashed()
 * @method static Builder|Event query()
 * @method static Builder|Event whereColor($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereCreatedBy($value)
 * @method static Builder|Event whereDeletedAt($value)
 * @method static Builder|Event whereDeletedBy($value)
 * @method static Builder|Event whereEndDate($value)
 * @method static Builder|Event whereFrequency($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereInterval($value)
 * @method static Builder|Event whereLessonId($value)
 * @method static Builder|Event whereStartDate($value)
 * @method static Builder|Event whereTenantId($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUntil($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event withTrashed()
 * @method static Builder|Event withoutTrashed()
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

    /**
     * @throws InvalidArgument
     */
    public function humanReadable()
    {
        $rule = new Rule;
        $rule->setStartDate($this->start_date);
        $rule->setEndDate($this->end_date);
        $rule->setFreq(Str::upper($this->frequency));
        $rule->setInterval($this->interval);
        $rule->setUntil(Carbon::parse($this->until));
        $rule->setWeekStart('SU');

        $textTransformer = new TextTransformer(
            new Translator('fr')
        );

        return $textTransformer->transform($rule);
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
