<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Lesson extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = [
        'subject_id',
        'academic_level_id',
        'quota',
        'start_date',
        'end_date',
        'id',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(PrivateSchool::class, 'private_school_id', 'id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id', 'id');
    }

    public function orphans(): HasManyThrough
    {
        return $this->hasManyThrough(EventOccurrence::class, Orphan::class, 'lesson_id', 'id', 'id', 'event_id');
    }

    public function getName(): string
    {
        return $this->subject->getName().' - '.$this->academicLevel?->level;
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
        ];
    }
}
