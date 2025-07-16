<?php

namespace App\Models;

use Database\Factories\DomainFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Models\Domain as ModelsDomain;

/**
 * @property string $id
 * @property string $domain
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 *
 * @method static DomainFactory factory($count = null, $state = [])
 * @method static Builder<static>|Domain newModelQuery()
 * @method static Builder<static>|Domain newQuery()
 * @method static Builder<static>|Domain query()
 * @method static Builder<static>|Domain whereCreatedAt($value)
 * @method static Builder<static>|Domain whereDomain($value)
 * @method static Builder<static>|Domain whereId($value)
 * @method static Builder<static>|Domain whereTenantId($value)
 * @method static Builder<static>|Domain whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Domain extends ModelsDomain
{
    use HasFactory, HasUuids;

    protected $fillable = ['domain', 'tenant_id', 'id'];
}
