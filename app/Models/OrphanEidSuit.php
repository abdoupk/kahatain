<?php

namespace App\Models;

use Database\Factories\OrphanEidSuitFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $tenant_id
 * @property string $orphan_id
 * @property string|null $note
 * @property string|null $clothes_shop_name
 * @property string|null $clothes_shop_phone_number
 * @property string|null $shoes_shop_name
 * @property string|null $shoes_shop_phone_number
 * @property string|null $user_id
 * @property string|null $shoes_shop_address
 * @property array<array-key, mixed>|null $shoes_shop_location
 * @property string|null $clothes_shop_address
 * @property array<array-key, mixed>|null $clothes_shop_location
 * @property bool|null $shirt_completed
 * @property bool|null $shoes_completed
 * @property bool|null $pants_completed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $member
 * @property-read Orphan|null $orphan
 * @property-read Tenant|null $tenant
 *
 * @method static OrphanEidSuitFactory factory($count = null, $state = [])
 * @method static Builder<static>|OrphanEidSuit newModelQuery()
 * @method static Builder<static>|OrphanEidSuit newQuery()
 * @method static Builder<static>|OrphanEidSuit query()
 * @method static Builder<static>|OrphanEidSuit whereClothesShopAddress($value)
 * @method static Builder<static>|OrphanEidSuit whereClothesShopLocation($value)
 * @method static Builder<static>|OrphanEidSuit whereClothesShopName($value)
 * @method static Builder<static>|OrphanEidSuit whereClothesShopPhoneNumber($value)
 * @method static Builder<static>|OrphanEidSuit whereCreatedAt($value)
 * @method static Builder<static>|OrphanEidSuit whereId($value)
 * @method static Builder<static>|OrphanEidSuit whereNote($value)
 * @method static Builder<static>|OrphanEidSuit whereOrphanId($value)
 * @method static Builder<static>|OrphanEidSuit wherePantsCompleted($value)
 * @method static Builder<static>|OrphanEidSuit whereShirtCompleted($value)
 * @method static Builder<static>|OrphanEidSuit whereShoesCompleted($value)
 * @method static Builder<static>|OrphanEidSuit whereShoesShopAddress($value)
 * @method static Builder<static>|OrphanEidSuit whereShoesShopLocation($value)
 * @method static Builder<static>|OrphanEidSuit whereShoesShopName($value)
 * @method static Builder<static>|OrphanEidSuit whereShoesShopPhoneNumber($value)
 * @method static Builder<static>|OrphanEidSuit whereTenantId($value)
 * @method static Builder<static>|OrphanEidSuit whereUpdatedAt($value)
 * @method static Builder<static>|OrphanEidSuit whereUserId($value)
 *
 * @mixin Eloquent
 */
class OrphanEidSuit extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'clothes_shop_name',
        'clothes_shop_phone_number',
        'shoes_shop_name',
        'shoes_shop_phone_number',
        'note',
        'shoes_shop_address',
        'clothes_shop_address',
        'shoes_shop_location',
        'clothes_shop_location',
        'shirt_completed',
        'shoes_completed',
        'pants_completed',
        'orphan_id',
        'user_id',
        'tenant_id',
    ];

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'orphan_id' => 'string',
            'user_id' => 'string',
            'shoes_shop_location' => 'array',
            'clothes_shop_location' => 'array',
        ];
    }
}
