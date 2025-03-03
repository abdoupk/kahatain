<?php

namespace App\Models;

use DB;
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
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
            'preview_date' => 'date',
            'location' => 'array',
        ];
    }
}
