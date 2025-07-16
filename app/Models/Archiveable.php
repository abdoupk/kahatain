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
 * @property-read Tenant $tenant
 *
 * @method static Builder<static>|Archiveable newModelQuery()
 * @method static Builder<static>|Archiveable newQuery()
 * @method static Builder<static>|Archiveable query()
 * @method static Builder<static>|Archiveable whereArchiveId($value)
 * @method static Builder<static>|Archiveable whereArchiveableId($value)
 * @method static Builder<static>|Archiveable whereArchiveableType($value)
 * @method static Builder<static>|Archiveable whereTenantId($value)
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
