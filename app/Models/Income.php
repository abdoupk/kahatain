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
 * @property string $cnr
 * @property string $cnas
 * @property string $casnos
 * @property string $pension
 * @property string $account
 * @property string $other_income
 * @property float|null $total_income
 * @property string $sponsor_id
 * @property string $tenant_id
 * @property-read Sponsor $sponsor
 * @property-read Tenant $tenant
 *
 * @method static IncomeFactory factory($count = null, $state = [])
 * @method static Builder|Income newModelQuery()
 * @method static Builder|Income newQuery()
 * @method static Builder|Income query()
 * @method static Builder|Income whereAccount($value)
 * @method static Builder|Income whereCasnos($value)
 * @method static Builder|Income whereCnas($value)
 * @method static Builder|Income whereCnr($value)
 * @method static Builder|Income whereId($value)
 * @method static Builder|Income whereOtherIncome($value)
 * @method static Builder|Income wherePension($value)
 * @method static Builder|Income whereSponsorId($value)
 * @method static Builder|Income whereTenantId($value)
 * @method static Builder|Income whereTotalIncome($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\TFactory|null $use_factory
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
