<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Archiveable extends Pivot
{
    use BelongsToTenant;

    protected $fillable = [
        'archive_id',
        'archiveable_id',
        'archiveable_type',
        'metadata',
    ];

    protected $table = 'archiveables';
}
