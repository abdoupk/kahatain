<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * @property string $id
 * @property string $tokenable_type
 * @property string $tokenable_id
 * @property string $name
 * @property string $token
 * @property array<array-key, mixed>|null $abilities
 * @property Carbon|null $last_used_at
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $tokenable
 *
 * @method static Builder<static>|PersonalAccessToken newModelQuery()
 * @method static Builder<static>|PersonalAccessToken newQuery()
 * @method static Builder<static>|PersonalAccessToken query()
 * @method static Builder<static>|PersonalAccessToken whereAbilities($value)
 * @method static Builder<static>|PersonalAccessToken whereCreatedAt($value)
 * @method static Builder<static>|PersonalAccessToken whereExpiresAt($value)
 * @method static Builder<static>|PersonalAccessToken whereId($value)
 * @method static Builder<static>|PersonalAccessToken whereLastUsedAt($value)
 * @method static Builder<static>|PersonalAccessToken whereName($value)
 * @method static Builder<static>|PersonalAccessToken whereToken($value)
 * @method static Builder<static>|PersonalAccessToken whereTokenableId($value)
 * @method static Builder<static>|PersonalAccessToken whereTokenableType($value)
 * @method static Builder<static>|PersonalAccessToken whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';
}
