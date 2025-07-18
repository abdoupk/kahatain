<?php

namespace App\Models;

use Database\Factories\FamilyFactory;
use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $name
 * @property string|null $zone_id
 * @property string|null $branch_id
 * @property string $address
 * @property array<array-key, mixed>|null $location
 * @property string|null $file_number
 * @property Carbon|null $start_date
 * @property float|null $income_rate
 * @property float|null $total_income
 * @property float|null $difference_before_monthly_sponsorship
 * @property float|null $difference_after_monthly_sponsorship
 * @property float|null $monthly_sponsorship_rate
 * @property float|null $amount_from_association
 * @property float|null $ramadan_sponsorship_difference
 * @property string|null $ramadan_basket_category
 * @property string $tenant_id
 * @property float $aggregate_zakat_benefit
 * @property int $aggregate_white_meat_benefit
 * @property int $aggregate_red_meat_benefit
 * @property string|null $eid_al_adha_status
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $last_updated_at
 * @property string|null $deletion_reason
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Sponsorship> $aid
 * @property-read int|null $aid_count
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Collection<int, Baby> $babies
 * @property-read int|null $babies_count
 * @property-read Branch|null $branch
 * @property-read User|null $creator
 * @property-read Collection<int, Spouse> $deceased
 * @property-read int|null $deceased_count
 * @property-read Collection<int, FamilyEidAlAdha> $eidAlAdhas
 * @property-read int|null $eid_al_adhas_count
 * @property-read Furnishing|null $furnishings
 * @property-read Housing|null $housing
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read Collection<int, Need> $orphansNeeds
 * @property-read int|null $orphans_needs_count
 * @property-read Preview|null $preview
 * @property-read SecondSponsor|null $secondSponsor
 * @property-read Sponsor|null $sponsor
 * @property-read Collection<int, Need> $sponsorsNeeds
 * @property-read int|null $sponsors_needs_count
 * @property-read Spouse|null $spouse
 * @property-read Tenant $tenant
 * @property-read Zone|null $zone
 *
 * @method static FamilyFactory factory($count = null, $state = [])
 * @method static Builder<static>|Family newModelQuery()
 * @method static Builder<static>|Family newQuery()
 * @method static Builder<static>|Family onlyTrashed()
 * @method static Builder<static>|Family query()
 * @method static Builder<static>|Family whereAddress($value)
 * @method static Builder<static>|Family whereAggregateRedMeatBenefit($value)
 * @method static Builder<static>|Family whereAggregateWhiteMeatBenefit($value)
 * @method static Builder<static>|Family whereAggregateZakatBenefit($value)
 * @method static Builder<static>|Family whereAmountFromAssociation($value)
 * @method static Builder<static>|Family whereBranchId($value)
 * @method static Builder<static>|Family whereCreatedAt($value)
 * @method static Builder<static>|Family whereCreatedBy($value)
 * @method static Builder<static>|Family whereDeletedAt($value)
 * @method static Builder<static>|Family whereDeletedBy($value)
 * @method static Builder<static>|Family whereDeletionReason($value)
 * @method static Builder<static>|Family whereDifferenceAfterMonthlySponsorship($value)
 * @method static Builder<static>|Family whereDifferenceBeforeMonthlySponsorship($value)
 * @method static Builder<static>|Family whereEidAlAdhaStatus($value)
 * @method static Builder<static>|Family whereFileNumber($value)
 * @method static Builder<static>|Family whereId($value)
 * @method static Builder<static>|Family whereIncomeRate($value)
 * @method static Builder<static>|Family whereLocation($value)
 * @method static Builder<static>|Family whereMonthlySponsorshipRate($value)
 * @method static Builder<static>|Family whereName($value)
 * @method static Builder<static>|Family whereRamadanBasketCategory($value)
 * @method static Builder<static>|Family whereRamadanSponsorshipDifference($value)
 * @method static Builder<static>|Family whereStartDate($value)
 * @method static Builder<static>|Family whereTenantId($value)
 * @method static Builder<static>|Family whereTotalIncome($value)
 * @method static Builder<static>|Family whereUpdatedAt($value)
 * @method static Builder<static>|Family whereZoneId($value)
 * @method static Builder<static>|Family withTrashed()
 * @method static Builder<static>|Family withoutTrashed()
 *
 * @mixin Eloquent
 */
class Family extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'zone_id',
        'address',
        'created_by',
        'deleted_by',
        'file_number',
        'income_rate',
        'total_income',
        'start_date',
        'branch_id',
        'location',
        'difference_before_monthly_sponsorship',
        'difference_after_monthly_sponsorship',
        'monthly_sponsorship_rate',
        'amount_from_association',
        'difference_before_ramadan_sponsorship',
        'ramadan_basket_category',
        'ramadan_sponsorship_difference',
        'aggregate_zakat_benefit',
        'aggregate_white_meat_benefit',
        'aggregate_red_meat_benefit',
        'deletion_reason',
        'eid_al_adha_status',
        'last_updated_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }
        });

        static::softDeleted(function ($family): void {
            if (auth()->id()) {
                $family->deleted_by = auth()->id();

                $family->save();
            }
        });
    }

    public function unSearchWithRelations(): void
    {
        $this->unsearchable();

        $this->orphans()->unsearchable();

        $this->babies()->unsearchable();

        $this->orphansNeeds()->unsearchable();

        $this->sponsorsNeeds()->unsearchable();

        $this->sponsor()->unsearchable();

        $this->preview()->unsearchable();
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }

    public function babies(): HasMany
    {
        return $this->hasMany(Baby::class);
    }

    public function orphansNeeds(): HasManyThrough
    {
        return $this->hasManyThrough(Need::class, Orphan::class, 'id', 'needable_id', 'id', 'id');
    }

    public function sponsorsNeeds(): HasManyThrough
    {
        return $this->hasManyThrough(Need::class, Sponsor::class, 'id', 'needable_id', 'id', 'id');
    }

    public function sponsor(): HasOne
    {
        return $this->hasOne(Sponsor::class);
    }

    public function preview(): HasOne
    {
        return $this->hasOne(Preview::class);
    }

    public function aid(): MorphMany
    {
        return $this->morphMany(
            Sponsorship::class,
            'recipientable',
        );
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function searchableAs(): string
    {
        return 'families';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(
            [
                'zone',
                'secondSponsor',
                'spouse',
                'branch',
                'sponsor.incomes',
                'orphans',
                'aid',
                'housing',
                'furnishings',
            ]
        );
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tenant_id' => $this->tenant_id,
            'start_date' => (int) strtotime($this->start_date),
            'last_updated_at' => (int) strtotime($this->last_updated_at),
            'file_number' => $this->file_number,
            'address' => [
                'address' => $this->address,
                'zone' => [
                    'name' => $this->zone?->name,
                    'id' => $this->zone?->id,
                ],
            ],
            'sponsor' => [
                'id' => $this->sponsor?->id,
                'name' => $this->sponsor?->getName(),
                'academic_level_id' => $this->sponsor?->academic_level_id,
            ],
            'spouse' => [
                'name' => $this->spouse?->getName(),
                'function' => $this->spouse?->function,
            ],
            'second_sponsor' => [
                'name' => $this->secondSponsor?->getName(),
                'degree_of_kinship' => $this->secondSponsor?->degree_of_kinship,
                'address' => $this->secondSponsor?->address,
            ],
            'housing' => $this->housing?->only(['id', 'name', 'value', 'number_of_rooms', 'housing_receipt_number', 'other_properties']),
            'furnishings' => $this->furnishings?->only(['television', 'refrigerator', 'fireplace', 'washing_machine', 'water_heater', 'oven', 'wardrobe', 'cupboard', 'covers', 'mattresses', 'other_furnishings']),
            'branch' => $this->branch?->only(['id', 'name']),
            'total_income' => $this->total_income,
            'orphans_count' => $this->orphans->count(),
            'income_rate' => $this->income_rate,
            'difference_before_monthly_sponsorship' => $this->difference_before_monthly_sponsorship,
            'difference_after_monthly_sponsorship' => $this->difference_after_monthly_sponsorship,
            'monthly_sponsorship_rate' => $this->monthly_sponsorship_rate * 100,
            'amount_from_association' => $this->amount_from_association,
            'aggregate_zakat_benefit' => $this->aggregate_zakat_benefit,
            'basket_from_association' => $this->difference_before_monthly_sponsorship > 0,
            'amount_from_benefactor' => $this->aid->where('sponsorship_type', '!=', 'monthly_basket')->sum('amount'),
            'basket_from_benefactor' => $this->aid->where('sponsorship_type', '=', 'monthly_basket')->sum('amount'),
            'ramadan_basket_category' => $this->ramadan_basket_category,
            'ramadan_sponsorship_difference' => $this->ramadan_sponsorship_difference,
            'created_at' => strtotime($this->created_at),
            '_geo' => [
                'lat' => $this->location['lat'],
                'lng' => $this->location['lng'],
            ],
            'aggregate_white_meat_benefit' => $this->aggregate_white_meat_benefit,
            'aggregate_red_meat_benefit' => $this->aggregate_red_meat_benefit,
            'eid_al_adha_status' => $this->eid_al_adha_status,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function archives(): MorphToMany
    {
        return $this->morphToMany(Archive::class, 'archiveable');
    }

    public function deleteWithRelationships(string $userId, string $reason): void
    {
        $this->update([
            'deletion_reason' => $reason,
        ]);

        $this->babies()->delete();

        DB::table('needs')->where('needable_id', $this->sponsor->id)
            ->orWhereIn('needable_id', $this->orphans->pluck('id'))
            ->update(['deleted_at' => now(), 'deleted_by' => $userId]);

        $this->sponsor()->update([
            'deleted_at' => now(),
            'deleted_by' => $userId,
        ]);

        $this->orphans()->update([
            'deleted_at' => now(),
            'deleted_by' => $userId,
        ]);
    }

    public function forceDeleteWithRelationships(): void
    {
        $this->forceDelete();

        $this->babies()->forceDelete();

        DB::table('needs')->where('needable_id', $this->sponsor->id)
            ->orWhereIn('needable_id', $this->orphans->pluck('id'))
            ->forceDelete();

        $this->sponsor()->forceDelete();

        $this->orphans()->forceDelete();

        $this->deceased()->delete();

        $this->housing()->delete();

        $this->spouse()->delete();

        $this->furnishings()->delete();

        $this->secondSponsor()->delete();

        $this->preview()->forceDelete();
    }

    public function deceased(): HasMany
    {
        return $this->hasMany(Spouse::class);
    }

    public function housing(): HasOne
    {
        return $this->hasOne(Housing::class);
    }

    public function spouse(): HasOne
    {
        return $this->hasOne(Spouse::class);
    }

    public function furnishings(): HasOne
    {
        return $this->hasOne(Furnishing::class);
    }

    public function secondSponsor(): HasOne
    {
        return $this->hasOne(SecondSponsor::class);
    }

    public function eidAlAdhas(): HasMany
    {
        return $this->hasMany(FamilyEidAlAdha::class);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'last_updated_at' => 'date',
            'preview_date' => 'date',
            'location' => 'array',
        ];
    }
}
