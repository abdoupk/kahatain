<?php

namespace App\Models;

use Database\Factories\IncomeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 *
 *
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
 * @mixin Eloquent
 */
class Income extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

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
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
