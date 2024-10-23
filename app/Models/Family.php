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
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property int $id
 * @property string $name
 * @property string $report
 * @property string $tenant_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @method static Builder|Family newModelQuery()
 * @method static Builder|Family newQuery()
 * @method static Builder|Family query()
 * @method static Builder|Family whereCreatedAt($value)
 * @method static Builder|Family whereId($value)
 * @method static Builder|Family whereName($value)
 * @method static Builder|Family whereReport($value)
 * @method static Builder|Family whereTenantId($value)
 * @method static Builder|Family whereUpdatedAt($value)
 *
 * @property-read Collection<int, Furnishing> $furnishings
 * @property-read int|null $furnishings_count
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read SecondSponsor|null $secondSponsor
 * @property-read Sponsor|null $sponsor
 * @property-read Collection<int, FamilySponsorship> $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read Spouse|null $spouse
 * @property-read Tenant $tenant
 *
 * @method static FamilyFactory factory($count = null, $state = [])
 *
 * @property string $zone_id
 * @property string $address
 * @property int $file_number
 * @property string $start_date
 * @property-read Zone|null $zone
 *
 * @method static Builder|Family whereAddress($value)
 * @method static Builder|Family whereFileNumber($value)
 * @method static Builder|Family whereStartDate($value)
 * @method static Builder|Family whereZoneId($value)
 *
 * @property Carbon|null $deleted_at
 *
 * @method static Builder|Family onlyTrashed()
 * @method static Builder|Family whereDeletedAt($value)
 * @method static Builder|Family withTrashed()
 * @method static Builder|Family withoutTrashed()
 *
 * @property string|null $branch_id
 *
 * @method static Builder|Family whereBranchId($value)
 *
 * @property-read Spouse|null $deceased
 * @property-read Housing|null $housing
 * @property-read Preview|null $preview
 * @property-read Collection<int, Baby> $babies
 * @property-read int|null $babies_count
 * @property-read Collection<int, OrphanSponsorship> $orphansSponsorships
 * @property-read int|null $orphans_sponsorships_count
 * @property-read Collection<int, SponsorSponsorship> $sponsorSponsorships
 * @property-read int|null $sponsor_sponsorships_count
 * @property-read Branch|null $branch
 * @property string|null $created_by
 * @property-read User|null $creator
 *
 * @method static Builder|Family whereCreatedBy($value)
 *
 * @property float|null $income_rate
 * @property float|null $total_income
 * @property string|null $deleted_by
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Collection<int, Need> $orphansNeeds
 * @property-read int|null $orphans_needs_count
 * @property-read Collection<int, Need> $sponsorsNeeds
 * @property-read int|null $sponsors_needs_count
 *
 * @method static Builder|Family whereDeletedBy($value)
 * @method static Builder|Family whereIncomeRate($value)
 * @method static Builder|Family whereTotalIncome($value)
 *
 * @mixin Eloquent
 */
class Family extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

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

        $this->orphansSponsorships->unsearchable();

        $this->sponsorSponsorships->unsearchable();

        $this->orphans->unsearchable();

        $this->babies->unsearchable();

        $this->orphansNeeds->unsearchable();

        $this->sponsorsNeeds->unsearchable();

        $this->sponsor()->unsearchable();

        $this->sponsorships->unsearchable();

        $this->preview->unsearchable();
    }

    public function sponsor(): HasOne
    {
        return $this->hasOne(Sponsor::class);
    }

    public function sponsorships(): HasOne
    {
        return $this->hasOne(FamilySponsorship::class);
    }

    public function aid(): MorphMany
    {
        return $this->morphMany(
            Sponsorship::class,
            'recipientable',
        );
    }

    public function sponsorSponsorships(): HasOneThrough
    {
        return $this->hasOneThrough(SponsorSponsorship::class, Sponsor::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orphansSponsorships(): HasManyThrough
    {
        return $this->hasManyThrough(OrphanSponsorship::class, Orphan::class);
    }

    public function orphansNeeds(): HasManyThrough
    {
        return $this->hasManyThrough(Need::class, Orphan::class, 'id', 'needable_id', 'id', 'id');
    }

    public function sponsorsNeeds(): HasManyThrough
    {
        return $this->hasManyThrough(Need::class, Sponsor::class, 'id', 'needable_id', 'id', 'id');
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
                'sponsorships',
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
            'branch' => $this->branch?->only(['id', 'name']),
            'total_income' => $this->total_income,
            'orphans_count' => $this->orphans->count(),
            'family_sponsorships' => [
                'monthly_allowance' => boolval($this->sponsorships?->monthly_allowance),
                'ramadan_basket' => boolval($this->sponsorships?->ramadan_basket),
                'zakat' => boolval($this->sponsorships?->zakat),
                'housing_assistance' => boolval($this->sponsorships?->housing_assistance),
                'eid_el_adha' => boolval($this->sponsorships?->eid_al_adha),
            ],
            'income_rate' => $this->income_rate,
            'created_at' => strtotime($this->created_at),
            '_geo' => [
                'lat' => $this->location['lat'],
                'lng' => $this->location['lng'],
            ],
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

    public function deleteWithRelationships(): void
    {
        $this->delete();

        $this->babies()->delete();

        DB::table('needs')->where('needable_id', $this->sponsor->id)
            ->orWhereIn('needable_id', $this->orphans->pluck('id'))
            ->update(['deleted_at' => now(), 'deleted_by' => auth()->user()->id]);

        $this->sponsor()->update([
            'deleted_at' => now(),
            'deleted_by' => auth()->user()->id,
        ]);

        $this->orphans()->update([
            'deleted_at' => now(),
            'deleted_by' => auth()->user()->id,
        ]);
    }

    public function babies(): HasMany
    {
        return $this->hasMany(Baby::class);
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
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

    public function deceased(): HasOne
    {
        return $this->hasOne(Spouse::class);
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

    public function preview(): HasOne
    {
        return $this->hasOne(Preview::class);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'preview_date' => 'date',
            'location' => 'array',
        ];
    }
}
