<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $archive_id
 * @property string $archiveable_id
 * @property string $archiveable_type
 * @property string $tenant_id
 *
 * @method static Builder|Archiveable newModelQuery()
 * @method static Builder|Archiveable newQuery()
 * @method static Builder|Archiveable query()
 * @method static Builder|Archiveable whereArchiveId($value)
 * @method static Builder|Archiveable whereArchiveableId($value)
 * @method static Builder|Archiveable whereArchiveableType($value)
 * @method static Builder|Archiveable whereTenantId($value)
 *
 * @mixin Eloquent
 */
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
