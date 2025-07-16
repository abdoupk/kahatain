<?php

namespace App\Models;

use Database\Factories\IncomeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property bool|null $cnr
 * @property bool|null $cnas
 * @property bool|null $casnos
 * @property bool|null $pension
 * @property array<array-key, mixed> $account
 * @property float|null $other_income
 * @property float|null $total_income
 * @property string $sponsor_id
 * @property string $tenant_id
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Sponsor $sponsor
 * @property-read Tenant $tenant
 *
 * @method static IncomeFactory factory($count = null, $state = [])
 * @method static Builder<static>|Income newModelQuery()
 * @method static Builder<static>|Income newQuery()
 * @method static Builder<static>|Income query()
 * @method static Builder<static>|Income whereAccount($value)
 * @method static Builder<static>|Income whereCasnos($value)
 * @method static Builder<static>|Income whereCnas($value)
 * @method static Builder<static>|Income whereCnr($value)
 * @method static Builder<static>|Income whereId($value)
 * @method static Builder<static>|Income whereOtherIncome($value)
 * @method static Builder<static>|Income wherePension($value)
 * @method static Builder<static>|Income whereSponsorId($value)
 * @method static Builder<static>|Income whereTenantId($value)
 * @method static Builder<static>|Income whereTotalIncome($value)
 *
 * @mixin Eloquent
 */
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
