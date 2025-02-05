<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class FamilyEidAlAdha extends Model
{
    use BelongsToTenant, HasUuids;

    protected $fillable = [
        'family_id',
        'tenant_id',
        'status',
        'updated_by',
        'year',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
