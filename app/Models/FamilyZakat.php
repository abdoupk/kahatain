<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class FamilyZakat extends Model
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'amount',
        'family_id',
        'zakat_id',
    ];

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class);
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'family_id' => 'string',
            'zakat_id' => 'string',
        ];
    }
}
