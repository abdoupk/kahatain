<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Scout\Searchable;
use Spatie\Permission\Models\Role as SpatieRole;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
            'permissions_count' => $this->permissions_count,
            'users_count' => (int) $this->users_count,
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }
}
