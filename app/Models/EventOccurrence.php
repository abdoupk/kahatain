<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $start_date
 * @property string $end_date
 * @property string $lesson_id
 * @property string $event_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Event $event
 * @property-read Lesson $lesson
 * @property-read EventOccurrenceOrphan|null $pivot
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read Tenant $tenant
 *
 * @method static Builder<static>|EventOccurrence newModelQuery()
 * @method static Builder<static>|EventOccurrence newQuery()
 * @method static Builder<static>|EventOccurrence onlyTrashed()
 * @method static Builder<static>|EventOccurrence query()
 * @method static Builder<static>|EventOccurrence whereCreatedAt($value)
 * @method static Builder<static>|EventOccurrence whereDeletedAt($value)
 * @method static Builder<static>|EventOccurrence whereEndDate($value)
 * @method static Builder<static>|EventOccurrence whereEventId($value)
 * @method static Builder<static>|EventOccurrence whereId($value)
 * @method static Builder<static>|EventOccurrence whereLessonId($value)
 * @method static Builder<static>|EventOccurrence whereStartDate($value)
 * @method static Builder<static>|EventOccurrence whereTenantId($value)
 * @method static Builder<static>|EventOccurrence whereUpdatedAt($value)
 * @method static Builder<static>|EventOccurrence withTrashed()
 * @method static Builder<static>|EventOccurrence withoutTrashed()
 *
 * @mixin Eloquent
 */
class EventOccurrence extends Model
{
    use BelongsToTenant, BelongsToTenant, HasUuids, SoftDeletes;

    protected $fillable = [
        'event_id',
        'id',
        'lesson_id',
        'start_date',
        'end_date',
        'tenant_id',
    ];

    public function orphans(): BelongsToMany
    {
        return $this->belongsToMany(
            Orphan::class,
            'event_occurrence_orphan',
            'event_occurrence_id',
            'orphan_id'
        )->using(EventOccurrenceOrphan::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
