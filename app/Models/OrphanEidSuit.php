<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
