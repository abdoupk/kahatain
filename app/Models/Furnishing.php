<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Furnishing extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'television',
        'refrigerator',
        'fireplace',
        'washing_machine',
        'water_heater',
        'oven',
        'wardrobe',
        'cupboard',
        'covers',
        'mattresses',
        'other_furnishings',
        'family_id',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    protected function casts(): array
    {
        return [
            'television' => 'array',
            'refrigerator' => 'array',
            'fireplace' => 'array',
            'washing_machine' => 'array',
            'water_heater' => 'array',
            'oven' => 'array',
            'wardrobe' => 'array',
            'cupboard' => 'array',
            'covers' => 'array',
            'mattresses' => 'array',
            'other_furnishings' => 'array',
        ];
    }
}
