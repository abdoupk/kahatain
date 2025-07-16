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
 * @property string $competence_id
 * @property string $tenant_id
 * @property-read Tenant $tenant
 *
 * @method static Builder<static>|CompetenceUser newModelQuery()
 * @method static Builder<static>|CompetenceUser newQuery()
 * @method static Builder<static>|CompetenceUser query()
 * @method static Builder<static>|CompetenceUser whereCompetenceId($value)
 * @method static Builder<static>|CompetenceUser whereId($value)
 * @method static Builder<static>|CompetenceUser whereTenantId($value)
 * @method static Builder<static>|CompetenceUser whereUserId($value)
 *
 * @mixin Eloquent
 */
class CompetenceUser extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;
}
