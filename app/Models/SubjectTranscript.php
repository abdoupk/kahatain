<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SubjectTranscript extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $table = 'subject_transcripts';

    protected $fillable = [
        'rate',
        'subject_id',
        'transcript_id',
        'tenant_id',
    ];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function transcript(): BelongsTo
    {
        return $this->belongsTo(Transcript::class);
    }
}
