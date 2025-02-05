<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SubjectTranscript extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $table = 'subject_transcript';

    protected $fillable = [
        'grade',
        'subject_id',
        'transcript_id',
        'tenant_id',
    ];
}
