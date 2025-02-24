<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Income extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia;

    public $timestamps = false;

    protected $fillable = [
        'cnr',
        'cnas',
        'casnos',
        'pension',
        'account',
        'other_income',
        'total_income',
        'sponsor_id',
        'tenant_id',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(268)
            ->height(320)
            ->nonOptimized();
    }

    protected function casts(): array
    {
        return [
            'account' => 'array',
        ];
    }
}
