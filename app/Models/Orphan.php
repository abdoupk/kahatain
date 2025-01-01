<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Orphan extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'family_status',
        'academic_average',
        'health_status',
        'academic_level_id',
        'speciality_id',
        'speciality_type',
        'academic_year',
        'shoes_size',
        'pants_size',
        'shirt_size',
        'is_handicapped',
        'is_unemployed',
        'income',
        'note',
        'family_id',
        'sponsor_id',
        'created_by',
        'deleted_by',
        'deleted_at',
        'ccp',
        'phone_number',
        'institution_id',
        'institution_type',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }

            if ($model->is_unemployed) {
                $model->income = setUnemployedOrphanIncome($model);
            } elseif ($model->birth_date->age > 18) {
                $model->income = calculateOrphanExactIncome($model);
            }
        });

        static::softDeleted(function ($model): void {
            if (auth()->id()) {
                $model->deleted_by = auth()->id();

                $model->save();
            }
        });
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function shoesSize(): BelongsTo
    {
        return $this->belongsTo(ShoeSize::class, 'shoes_size', 'id');
    }

    public function pantsSize(): BelongsTo
    {
        return $this->belongsTo(ClothesSize::class, 'pants_size', 'id');
    }

    public function shirtSize(): BelongsTo
    {
        return $this->belongsTo(ClothesSize::class, 'shirt_size', 'id');
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->getName(),
            'birth_date' => strtotime($this->birth_date),
            'readable_birth_date' => $this->birth_date,
            'health_status' => $this->health_status,
            'phone_number' => $this->phone_number,
            'ccp' => $this->ccp,
            'family_status' => [
                'ar' => $this->family_status ? __('family_statuses.'.$this->family_status, locale: 'ar') : '',
                'fr' => $this->family_status ? __('family_statuses.'.$this->family_status, locale: 'fr') : '',
                'en' => $this->family_status ? __('family_statuses.'.$this->family_status, locale: 'en') : '',
            ],
            'shoes_size' => $this->shoesSize?->label,
            'shirt_size' => $this->shirtSize?->label,
            'pants_size' => $this->pantsSize?->label,
            'income' => (float) $this->income,
            'gender' => $this->gender,
            'is_handicapped' => $this->is_handicapped,
            'is_unemployed' => $this->is_unemployed,
            'note' => $this->note,
            'academic_level' => [
                'id' => $this->academic_level_id,
                'i_id' => $this->academicLevel?->i_id,
                'level' => $this->academicLevel?->level,
                'phase' => $this->academicLevel?->phase,
                'phase_key' => $this->academicLevel?->phase_key,
            ],
            'institution' => [
                'id' => $this->institution_id,
                'name' => $this->institution?->getName(),
            ],
            'speciality' => [
                'id' => $this->speciality?->id,
                'speciality' => $this->speciality?->speciality,
            ],
            'eid_suit' => [
                'id' => $this->eidSuit?->id,
                'shoes_shop_name' => $this->eidSuit?->shoes_shop_name,
                'shoes_shop_address' => $this->eidSuit?->shoes_shop_address,
                'shoes_shop_phone_number' => $this->eidSuit?->shoes_shop_phone_number,
                'clothes_shop_name' => $this->eidSuit?->clothes_shop_name,
                'clothes_shop_address' => $this->eidSuit?->clothes_shop_address,
                'clothes_shop_phone_number' => $this->eidSuit?->clothes_shop_phone_number,
                'clothes_shop_location' => $this->eidSuit?->clothes_shop_location,
                'shoes_shop_location' => $this->eidSuit?->shoes_shop_location,
            ],
            'tenant_id' => $this->tenant_id,
            'family_id' => $this->family_id,
            'family' => [
                'id' => $this->family_id,
                'name' => $this->family->name,
                'income_rate' => $this->family->income_rate,
                'zone' => [
                    'id' => $this->family->zone_id,
                    'name' => $this->family->zone->name,
                ],
            ],
            'academic_average' => $this->academic_average,
            'created_at' => strtotime($this->created_at),
            'updated_at' => strtotime($this->updated_at),
        ];
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function searchableAs(): string
    {
        return 'orphans';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load([
            'academicLevel',
            'speciality',
            'eidSuit',
            'shoesSize',
            'shirtSize',
            'pantsSize',
            'family',
        ]);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(
            AcademicLevel::class,
            'academic_level_id'
        );
    }

    public function vocationalTraining(): BelongsTo
    {
        return $this->belongsTo(
            VocationalTraining::class,
            'vocational_training_id'
        );
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(
            EventOccurrence::class,
            'event_occurrence_orphan',
            'orphan_id',
            'event_occurrence_id'
        );
    }

    public function archives(): MorphToMany
    {
        return $this->morphToMany(
            Archive::class,
            'archiveable'
        );
    }

    public function deleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $this->babyNeeds()->unsearchable();

        $needs->unsearchable();

        $needs->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
        ]);

        $this->delete();
    }

    public function needs(): MorphMany
    {
        return $this->morphMany(
            Need::class,
            'needable'
        );
    }

    public function babyNeeds(): HasOne
    {
        return $this->hasOne(Baby::class);
    }

    public function aid(): MorphMany
    {
        return $this->morphMany(
            Sponsorship::class,
            'recipientable',
        );
    }

    public function forceDeleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $this->babyNeeds()->unsearchable();

        $needs->unsearchable();

        $needs->forceDelete();

        $this->forceDelete();
    }

    public function restoreWithRelations(): void
    {
        $this->searchable();

        $this->restore();

        $baby = $this->babyNeeds()->withTrashed();

        $needs = $this->needs()->withTrashed();

        $baby->searchable();

        $needs->searchable();

        $needs->restore();

        $baby->restore();
    }

    public function transcripts(): HasMany
    {
        return $this->hasMany(Transcript::class);
    }

    public function eidSuit(): HasOne
    {
        return $this->hasOne(OrphanEidSuit::class);
    }

    public function institution(): BelongsTo
    {
        return $this->morphTo();
    }

    public function speciality(): BelongsTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
