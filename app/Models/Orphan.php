<?php

namespace App\Models;

use Database\Factories\OrphanFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon $birth_date
 * @property string|null $family_status
 * @property string|null $health_status
 * @property string|null $academic_level_id
 * @property string|null $shoes_size
 * @property string|null $pants_size
 * @property string|null $shirt_size
 * @property string $gender
 * @property float|null $income
 * @property bool $is_handicapped
 * @property bool $is_unemployed
 * @property string|null $ccp
 * @property float|null $academic_average
 * @property string|null $phone_number
 * @property string|null $institution_id
 * @property string|null $institution_type
 * @property int|null $speciality_id
 * @property string|null $speciality_type
 * @property string|null $note
 * @property string $tenant_id
 * @property string $family_id
 * @property string $sponsor_id
 * @property string $created_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Collection<int, Sponsorship> $aid
 * @property-read int|null $aid_count
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Baby|null $babyNeeds
 * @property-read User $creator
 * @property-read OrphanEidSuit|null $eidSuit
 * @property-read Collection<int, EventOccurrence> $events
 * @property-read int|null $events_count
 * @property-read Family $family
 * @property-read Model|Eloquent|null $institution
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Need> $needs
 * @property-read int|null $needs_count
 * @property-read ClothesSize|null $pantsSize
 * @property-read ClothesSize|null $shirtSize
 * @property-read ShoeSize|null $shoesSize
 * @property-read Model|Eloquent|null $speciality
 * @property-read Sponsor $sponsor
 * @property-read Tenant $tenant
 * @property-read Collection<int, Transcript> $transcripts
 * @property-read int|null $transcripts_count
 *
 * @method static OrphanFactory factory($count = null, $state = [])
 * @method static Builder<static>|Orphan newModelQuery()
 * @method static Builder<static>|Orphan newQuery()
 * @method static Builder<static>|Orphan onlyTrashed()
 * @method static Builder<static>|Orphan query()
 * @method static Builder<static>|Orphan whereAcademicAverage($value)
 * @method static Builder<static>|Orphan whereAcademicLevelId($value)
 * @method static Builder<static>|Orphan whereBirthDate($value)
 * @method static Builder<static>|Orphan whereCcp($value)
 * @method static Builder<static>|Orphan whereCreatedAt($value)
 * @method static Builder<static>|Orphan whereCreatedBy($value)
 * @method static Builder<static>|Orphan whereDeletedAt($value)
 * @method static Builder<static>|Orphan whereDeletedBy($value)
 * @method static Builder<static>|Orphan whereFamilyId($value)
 * @method static Builder<static>|Orphan whereFamilyStatus($value)
 * @method static Builder<static>|Orphan whereFirstName($value)
 * @method static Builder<static>|Orphan whereGender($value)
 * @method static Builder<static>|Orphan whereHealthStatus($value)
 * @method static Builder<static>|Orphan whereId($value)
 * @method static Builder<static>|Orphan whereIncome($value)
 * @method static Builder<static>|Orphan whereInstitutionId($value)
 * @method static Builder<static>|Orphan whereInstitutionType($value)
 * @method static Builder<static>|Orphan whereIsHandicapped($value)
 * @method static Builder<static>|Orphan whereIsUnemployed($value)
 * @method static Builder<static>|Orphan whereLastName($value)
 * @method static Builder<static>|Orphan whereNote($value)
 * @method static Builder<static>|Orphan wherePantsSize($value)
 * @method static Builder<static>|Orphan wherePhoneNumber($value)
 * @method static Builder<static>|Orphan whereShirtSize($value)
 * @method static Builder<static>|Orphan whereShoesSize($value)
 * @method static Builder<static>|Orphan whereSpecialityId($value)
 * @method static Builder<static>|Orphan whereSpecialityType($value)
 * @method static Builder<static>|Orphan whereSponsorId($value)
 * @method static Builder<static>|Orphan whereTenantId($value)
 * @method static Builder<static>|Orphan whereUpdatedAt($value)
 * @method static Builder<static>|Orphan withTrashed()
 * @method static Builder<static>|Orphan withoutTrashed()
 *
 * @mixin Eloquent
 */
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

            $model->family_status = setOrphanFamilyStatus($model);

            $model->is_unemployed = setOrphanEmploymentStatus($model);

            if ($model->is_handicapped) {
                $model->income = setHandicappedOrphanIncome($model);
            } elseif ($model->birth_date->age > 18) {
                $model->income = calculateOrphanExactIncome($model);
            }
        });

        static::updating(function (self $model): void {
            $model->family_status = setOrphanFamilyStatus($model);

            $model->is_unemployed = setOrphanEmploymentStatus($model);

            if ($model->is_handicapped) {
                $model->income = setHandicappedOrphanIncome($model);
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
        /* @var UniversitySpeciality | VocationalTrainingSpeciality $speciality */

        /* @var University | VocationalTrainingCenter | School $institution */

        $speciality = $this->speciality;
        $institution = $this->institution;

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
                'name' => $institution?->getName(),
            ],
            'speciality' => [
                'id' => $speciality?->id,
                'speciality' => $speciality?->speciality,
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
                'income_rate' => (float) $this->family->income_rate,
                'last_updated_at' => (int) strtotime($this->family->last_updated_at),
                'zone' => [
                    'id' => $this->family->zone_id,
                    'name' => $this->family->zone?->name,
                ],
                'branch' => [
                    'id' => $this->family->branch_id,
                    'name' => $this->family->branch?->name,
                ],
            ],
            'sponsor' => [
                'id' => $this->sponsor_id,
                'name' => $this->sponsor->getName(),
                'phone_number' => $this->sponsor?->phone_number,
            ],
            'academic_average' => (float) $this->academic_average,
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
            'family.zone',
            'family.branch',
            'institution',
            'sponsor',
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

        $transcripts = $this->transcripts();

        $this->babyNeeds()->unsearchable();

        $needs->unsearchable();

        $transcripts->unsearchable();

        $transcripts->delete();

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

    public function transcripts(): HasMany
    {
        return $this->hasMany(Transcript::class);
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
