<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class HighEducationTranscript extends Model
{
    use BelongsToTenant, HasUuids;

    protected $fillable = [
        'academic_level_id',
        'average',
        'orphan_id',
        'semester',
    ];
}
