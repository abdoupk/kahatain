<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Housing extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'value',
        'family_id',
        'housing_receipt_number',
        'number_of_rooms',
        'other_properties',
        'tenant_id',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
