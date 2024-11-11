<?php

namespace App\Models;

use Database\Factories\competenceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $name
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant|null $tenant
 *
 * @method static competenceFactory factory($count = null, $state = [])
 * @method static Builder<static>|competence newModelQuery()
 * @method static Builder<static>|competence newQuery()
 * @method static Builder<static>|competence query()
 * @method static Builder<static>|competence whereCreatedAt($value)
 * @method static Builder<static>|competence whereId($value)
 * @method static Builder<static>|competence whereName($value)
 * @method static Builder<static>|competence whereTenantId($value)
 * @method static Builder<static>|competence whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class competence extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
        ];
    }

    public function searchableAs(): string
    {
        return 'competences';
    }
}
