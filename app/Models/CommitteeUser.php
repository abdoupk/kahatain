<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $user_id
 * @property string $committee_id
 * @property string $tenant_id
 *
 * @method static Builder<static>|CommitteeUser newModelQuery()
 * @method static Builder<static>|CommitteeUser newQuery()
 * @method static Builder<static>|CommitteeUser query()
 * @method static Builder<static>|CommitteeUser whereCommitteeId($value)
 * @method static Builder<static>|CommitteeUser whereId($value)
 * @method static Builder<static>|CommitteeUser whereTenantId($value)
 * @method static Builder<static>|CommitteeUser whereUserId($value)
 *
 * @property-read Tenant $tenant
 *
 * @mixin Eloquent
 */
class CommitteeUser extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $table = 'committee_user';

    protected $fillable = [
        'committee_id',
        'user_id',
        'tenant_id',
    ];

    protected function casts(): array
    {
        return [
            'committee_id' => 'string',
            'user_id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}
