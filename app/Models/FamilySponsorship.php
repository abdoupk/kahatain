<?php

namespace App\Models;

use Database\Factories\FamilySponsorshipFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 *
 *
 * @property string $id
 * @property string $family_id
 * @property string|null $monthly_allowance
 * @property string|null $ramadan_basket
 * @property string|null $zakat
 * @property string|null $housing_assistance
 * @property string|null $eid_al_adha
 * @property string $tenant_id
 * @property string|null $created_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_at
 * @property-read Family $family
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read Tenant $tenant
 * @method static FamilySponsorshipFactory factory($count = null, $state = [])
 * @method static Builder|FamilySponsorship newModelQuery()
 * @method static Builder|FamilySponsorship newQuery()
 * @method static Builder|FamilySponsorship onlyTrashed()
 * @method static Builder|FamilySponsorship query()
 * @method static Builder|FamilySponsorship whereCreatedAt($value)
 * @method static Builder|FamilySponsorship whereDeletedAt($value)
 * @method static Builder|FamilySponsorship whereEidAlAdha($value)
 * @method static Builder|FamilySponsorship whereFamilyId($value)
 * @method static Builder|FamilySponsorship whereHousingAssistance($value)
 * @method static Builder|FamilySponsorship whereId($value)
 * @method static Builder|FamilySponsorship whereMonthlyAllowance($value)
 * @method static Builder|FamilySponsorship whereRamadanBasket($value)
 * @method static Builder|FamilySponsorship whereTenantId($value)
 * @method static Builder|FamilySponsorship whereUpdatedAt($value)
 * @method static Builder|FamilySponsorship whereZakat($value)
 * @method static Builder|FamilySponsorship withTrashed()
 * @method static Builder|FamilySponsorship withoutTrashed()
 * @mixin Eloquent
 */
class FamilySponsorship extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    public $timestamps = false;

    protected $table = 'family_sponsorship';

    protected $fillable = [
        //        'family_id',
        'monthly_allowance',
        'ramadan_basket',
        'zakat',
        'housing_assistance',
        'eid_al_adha',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function orphans(): HasManyThrough
    {
        return $this->hasManyThrough(Orphan::class, Family::class, 'id', 'family_id', 'family_id', 'id');
    }

    public function searchableAs(): string
    {
        return 'family_sponsorships';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(
            'family.sponsor.incomes',
            'family.zone',
            'family.orphans',
            'family.secondSponsor',
            'family.branch'
        );
    }

    public function toSearchableArray(): array
    {
        return [
            'monthly_allowance' => $this->monthly_allowance,
            'ramadan_basket' => $this->ramadan_basket,
            'zakat' => $this->zakat,
            'housing_assistance' => $this->housing_assistance,
            'eid_al_adha' => $this->eid_al_adha,
            'family' => [
                'address' => $this->family->address,
                'zone' => [
                    'id' => $this->family->zone?->id,
                    'name' => $this->family->zone?->name,
                ],
                'branch' => [
                    'id' => $this->family->branch->id,
                    'name' => $this->family->branch->name,
                ],
                'orphans_count' => $this->family->orphans->count(),
                'income_rate' => (float)$this->family->income_rate,
                'total_income' => $this->family->total_income,
            ],
            'sponsor' => [
                'name' => $this->family->sponsor?->getName(),
                'phone_number' => $this->family->sponsor?->phone_number,
            ],
            'tenant_id' => $this->tenant_id,
            'created_at' => $this->created_at,
        ];
    }
}
