<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\Permission\Models\Role as SpatieRole;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $uuid
 * @property string $name
 * @property string $guard_name
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Tenant $tenant
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions, $without = false)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereTenantId($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role whereUuid($value)
 * @method static Builder|Role withoutPermission($permissions)
 *
 * @mixin Eloquent
 */
class Role extends SpatieRole
{
    use BelongsToTenant, HasUuids, Searchable;

    protected $primaryKey = 'uuid';

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadCount(['users', 'permissions']);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->name !== 'super_admin';
    }

    public function toSearchableArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'permissions_count' => (int) $this->permissions_count,
            'users_count' => (int) $this->users_count,
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }
}
