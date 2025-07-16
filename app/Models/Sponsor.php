<?php

namespace App\Models;

use Database\Factories\SponsorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $phone_number
 * @property string $sponsor_type
 * @property string $gender
 * @property Carbon $birth_date
 * @property string|null $father_name
 * @property string|null $mother_name
 * @property string|null $birth_certificate_number
 * @property string|null $academic_level_id
 * @property string|null $function
 * @property string|null $health_status
 * @property string|null $diploma
 * @property bool $is_unemployed
 * @property string|null $ccp
 * @property string $family_id
 * @property string $tenant_id
 * @property string $created_by
 * @property string|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read User $creator
 * @property-read Family $family
 * @property-read Income|null $incomes
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Need> $needs
 * @property-read int|null $needs_count
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 * @property-read Tenant $tenant
 *
 * @method static SponsorFactory factory($count = null, $state = [])
 * @method static Builder<static>|Sponsor newModelQuery()
 * @method static Builder<static>|Sponsor newQuery()
 * @method static Builder<static>|Sponsor onlyTrashed()
 * @method static Builder<static>|Sponsor query()
 * @method static Builder<static>|Sponsor whereAcademicLevelId($value)
 * @method static Builder<static>|Sponsor whereBirthCertificateNumber($value)
 * @method static Builder<static>|Sponsor whereBirthDate($value)
 * @method static Builder<static>|Sponsor whereCcp($value)
 * @method static Builder<static>|Sponsor whereCreatedAt($value)
 * @method static Builder<static>|Sponsor whereCreatedBy($value)
 * @method static Builder<static>|Sponsor whereDeletedAt($value)
 * @method static Builder<static>|Sponsor whereDeletedBy($value)
 * @method static Builder<static>|Sponsor whereDiploma($value)
 * @method static Builder<static>|Sponsor whereFamilyId($value)
 * @method static Builder<static>|Sponsor whereFatherName($value)
 * @method static Builder<static>|Sponsor whereFirstName($value)
 * @method static Builder<static>|Sponsor whereFunction($value)
 * @method static Builder<static>|Sponsor whereGender($value)
 * @method static Builder<static>|Sponsor whereHealthStatus($value)
 * @method static Builder<static>|Sponsor whereId($value)
 * @method static Builder<static>|Sponsor whereIsUnemployed($value)
 * @method static Builder<static>|Sponsor whereLastName($value)
 * @method static Builder<static>|Sponsor whereMotherName($value)
 * @method static Builder<static>|Sponsor wherePhoneNumber($value)
 * @method static Builder<static>|Sponsor whereSponsorType($value)
 * @method static Builder<static>|Sponsor whereTenantId($value)
 * @method static Builder<static>|Sponsor whereUpdatedAt($value)
 * @method static Builder<static>|Sponsor withTrashed()
 * @method static Builder<static>|Sponsor withoutTrashed()
 *
 * @mixin Eloquent
 */
class Sponsor extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'sponsor_type',
        'birth_date',
        'father_name',
        'mother_name',
        'birth_certificate_number',
        'academic_level_id',
        'function',
        'is_unemployed',
        'health_status',
        'diploma',
        'ccp',
        'gender',
        'created_by',
        'deleted_by',
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
            }
        });
    }

    public function searchableAs(): string
    {
        return 'sponsors';
    }

    public function incomes(): HasOne
    {
        return $this->hasOne(Income::class);
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['incomes', 'academicLevel', 'orphans', 'family']);
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->getName(),
            'phone_number' => $this->phone_number,
            'sponsor_type' => $this->sponsor_type,
            'birth_date' => (int) strtotime($this->birth_date),
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_certificate_number' => $this->birth_certificate_number,
            'academic_level_id' => $this->academic_level_id,
            'income' => (float) $this->incomes?->total_income,
            'orphans_count' => $this->orphans?->count(),
            'academic_level' => [
                'id' => $this->academic_level_id,
                'i_id' => $this->academicLevel?->i_id,
                'level' => $this->academicLevel?->level,
                'phase' => $this->academicLevel?->phase,
            ],
            'family' => [
                'id' => $this->family_id,
                'income_rate' => $this->family?->income_rate,
            ],
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'gender' => $this->gender,
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }

    public function formattedPhoneNumber(): string
    {
        return formatPhoneNumber($this->phone_number);
    }

    public function deleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $needs->unsearchable();

        $needs->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
        ]);

        $this->delete();
    }

    public function needs(): MorphMany
    {
        return $this->morphMany(Need::class, 'needable');
    }

    public function forceDeleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $needs->unsearchable();

        $needs->forceDelete();

        $this->forceDelete();
    }

    public function restoreWithRelations(): void
    {
        $this->searchable();

        $this->restore();

        $needs = $this->needs()->withTrashed();

        $needs->searchable();

        $needs->restore();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->nonOptimized();
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
