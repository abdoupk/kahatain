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
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon $birth_date
 * @property string|null $family_status
 * @property string $health_status
 * @property int|null $academic_level_id
 * @property int|null $vocational_training_id
 * @property string|null $shoes_size
 * @property string|null $pants_size
 * @property string|null $shirt_size
 * @property string $gender
 * @property float|null $income
 * @property bool $is_handicapped
 * @property bool $is_unemployed
 * @property string|null $note
 * @property string $tenant_id
 * @property string $family_id
 * @property string $sponsor_id
 * @property string $created_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, AcademicAchievement> $academicAchievements
 * @property-read int|null $academic_achievements_count
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Baby|null $babyNeeds
 * @property-read Collection<int, CollegeAchievement> $collegeAchievements
 * @property-read int|null $college_achievements_count
 * @property-read User $creator
 * @property-read Collection<int, EventOccurrence> $events
 * @property-read int|null $events_count
 * @property-read Family $family
 * @property-read AcademicAchievement|null $lastAcademicYearAchievement
 * @property-read Collection<int, Need> $needs
 * @property-read int|null $needs_count
 * @property-read ClothesSize|null $pantsSize
 * @property-read ClothesSize|null $shirtSize
 * @property-read ShoeSize|null $shoesSize
 * @property-read Sponsor $sponsor
 * @property-read OrphanSponsorship|null $sponsorships
 * @property-read Tenant $tenant
 * @property-read VocationalTraining|null $vocationalTraining
 * @property-read Collection<int, VocationalTrainingAchievement> $vocationalTrainingAchievements
 * @property-read int|null $vocational_training_achievements_count
 *
 * @method static OrphanFactory factory($count = null, $state = [])
 * @method static Builder|Orphan newModelQuery()
 * @method static Builder|Orphan newQuery()
 * @method static Builder|Orphan onlyTrashed()
 * @method static Builder|Orphan query()
 * @method static Builder|Orphan whereAcademicLevelId($value)
 * @method static Builder|Orphan whereBirthDate($value)
 * @method static Builder|Orphan whereCreatedAt($value)
 * @method static Builder|Orphan whereCreatedBy($value)
 * @method static Builder|Orphan whereDeletedAt($value)
 * @method static Builder|Orphan whereDeletedBy($value)
 * @method static Builder|Orphan whereFamilyId($value)
 * @method static Builder|Orphan whereFamilyStatus($value)
 * @method static Builder|Orphan whereFirstName($value)
 * @method static Builder|Orphan whereGender($value)
 * @method static Builder|Orphan whereHealthStatus($value)
 * @method static Builder|Orphan whereId($value)
 * @method static Builder|Orphan whereIncome($value)
 * @method static Builder|Orphan whereIsHandicapped($value)
 * @method static Builder|Orphan whereIsUnemployed($value)
 * @method static Builder|Orphan whereLastName($value)
 * @method static Builder|Orphan whereNote($value)
 * @method static Builder|Orphan wherePantsSize($value)
 * @method static Builder|Orphan whereShirtSize($value)
 * @method static Builder|Orphan whereShoesSize($value)
 * @method static Builder|Orphan whereSponsorId($value)
 * @method static Builder|Orphan whereTenantId($value)
 * @method static Builder|Orphan whereUpdatedAt($value)
 * @method static Builder|Orphan whereVocationalTrainingId($value)
 * @method static Builder|Orphan withTrashed()
 * @method static Builder|Orphan withoutTrashed()
 *
 * @mixin Eloquent
 */
class Orphan extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'family_status',
        'health_status',
        'academic_level_id',
        'vocational_training_id',
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
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
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
            'family_status' => [
                'ar' => __('family_statuses.'.$this->family_status, locale: 'ar'),
                'fr' => __('family_statuses.'.$this->family_status, locale: 'fr'),
                'en' => __('family_statuses.'.$this->family_status, locale: 'en'),
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
                'level' => $this->academicLevel?->level,
                'phase' => $this->academicLevel?->phase,
            ],
            'academic_achievements' => $this->academicAchievements
                ->map(function (AcademicAchievement $academicAchievement) {
                    return [
                        'id' => $academicAchievement->id,
                        'academic_level' => $academicAchievement->academicLevel?->level,
                        'academic_year' => $academicAchievement->academic_year,
                        'first_trimester' => (float) number_format($academicAchievement->first_trimester, 2),
                        'second_trimester' => (float) number_format($academicAchievement->second_trimester, 2),
                        'third_trimester' => (float) number_format($academicAchievement->third_trimester, 2),
                        'average' => (float) number_format($academicAchievement->average, 2),
                    ];
                })->toArray(),
            'college_achievements' => $this->collegeAchievements
                ->map(function (CollegeAchievement $collegeAchievement) {
                    return [
                        'id' => $collegeAchievement->id,
                        'academic_level' => $collegeAchievement->academicLevel?->level,
                        'academic_year' => $collegeAchievement->year,
                        'first_semester' => (float) number_format(
                            $collegeAchievement->first_semester,
                            2
                        ),
                        'second_semester' => (float) number_format(
                            $collegeAchievement->second_semester,
                            2
                        ),
                        'average' => (float) number_format(
                            $collegeAchievement->average,
                            2
                        ),
                        'speciality' => $collegeAchievement->speciality,
                        'university' => $collegeAchievement->university,
                    ];
                })->toArray(),
            'vocational_training_achievements' => $this->vocationalTrainingAchievements
                ->map(function (
                    VocationalTrainingAchievement $vocationalTrainingAchievement
                ) {
                    return [
                        'id' => $vocationalTrainingAchievement->id,
                        'vocational_training_speciality' => $vocationalTrainingAchievement
                            ->vocationalTraining?->speciality,
                        'vocational_training_division' => $vocationalTrainingAchievement
                            ->vocationalTraining?->division,
                        'institute' => $vocationalTrainingAchievement->institute,
                    ];
                })->toArray(),
            'sponsorships' => [
                'medical_sponsorship' => boolval($this->sponsorships?->medical_sponsorship),
                'university_scholarship' => boolval($this->sponsorships?->university_scholarship),
                'association_trips' => boolval($this->sponsorships?->association_trips),
                'summer_camp' => boolval($this->sponsorships?->summer_camp),
                'eid_suit' => boolval($this->sponsorships?->eid_suit),
                'private_lessons' => boolval($this->sponsorships?->private_lessons),
                'school_bag' => boolval($this->sponsorships?->school_bag),
            ],
            'tenant_id' => $this->tenant_id,
            'family_id' => $this->family_id,
            'created_at' => strtotime($this->created_at),
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
            'academicAchievements.academicLevel',
            'sponsorships',
            'collegeAchievements.academicLevel',
            'vocationalTrainingAchievements.vocationalTraining',
            'shoesSize',
            'shirtSize',
            'pantsSize',
        ]);
    }

    public function academicAchievements(): HasMany
    {
        return $this->hasMany(AcademicAchievement::class);
    }

    public function lastAcademicYearAchievement(): HasOne
    {
        return $this->hasOne(AcademicAchievement::class, 'orphan_id')->with('academicLevel')
            ->where(function ($query): void {
                $query->whereRaw('academic_achievements.academic_year = ?', now()->year)
                    ->orWhereRaw('academic_achievements.academic_year = ? ', now()->year - 1);
            })
            ->latest('academic_achievements.academic_year');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function vocationalTrainingAchievements(): HasMany
    {
        return $this->hasMany(VocationalTrainingAchievement::class);
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

    public function collegeAchievements(): HasMany
    {
        return $this->hasMany(CollegeAchievement::class);
    }

    public function formatedLastAcademicYear(): string
    {
        if (is_null($this->lastAcademicYearAchievement)) {
            return '';
        }

        return $this->
            lastAcademicYearAchievement?->academicLevel
                ->level
            .' ('.
            $this->lastAcademicYearAchievement?->academic_year
            .')';
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

        $sponsorships = $this->sponsorships();

        $this->babyNeeds()->unsearchable();

        $needs->unsearchable();

        $sponsorships->unsearchable();

        $sponsorships->delete();

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

    public function sponsorships(): HasOne
    {
        return $this->hasOne(OrphanSponsorship::class);
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

        $sponsorships = $this->sponsorships();

        $this->babyNeeds()->unsearchable();

        $needs->unsearchable();

        $sponsorships->unsearchable();

        $sponsorships->forceDelete();

        $needs->forceDelete();

        $this->forceDelete();
    }

    public function restoreWithRelations(): void
    {
        $this->searchable();

        $this->restore();

        $baby = $this->babyNeeds()->withTrashed();

        $needs = $this->needs()->withTrashed();

        $sponsorships = $this->sponsorships()->withTrashed();

        $baby->searchable();

        $needs->searchable();

        $sponsorships->searchable();

        $needs->restore();

        $baby->restore();

        $sponsorships->restore();
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
