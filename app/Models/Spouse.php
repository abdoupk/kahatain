<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Spouse extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'death_date',
        'function',
        'income',
        'family_id',
        'tenant_id',
        'type',
    ];

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
        ];
    }
}
