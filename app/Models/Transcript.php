<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Transcript extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'trimester',
        'average',
        'orphan_id',
        'tenant_id',
    ];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->withPivot('grade')
            ->using(SubjectTranscript::class);
    }

    public function academicLevel(): HasOneThrough
    {
        return $this->hasOneThrough(AcademicLevel::class, Orphan::class, 'id', 'id', 'orphan_id', 'academic_level_id');
    }
}