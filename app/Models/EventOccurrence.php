<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
