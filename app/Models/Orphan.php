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
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
