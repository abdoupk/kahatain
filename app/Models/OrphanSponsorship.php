<?php

namespace App\Models;

use Database\Factories\OrphanSponsorshipFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $orphan_id
 * @property bool|null $medical_sponsorship
 * @property bool|null $university_scholarship
 * @property bool|null $association_trips
 * @property bool|null $summer_camp
 * @property bool|null $eid_suit
 * @property bool|null $private_lessons
 * @property bool|null $school_bag
 * @property string $tenant_id
 * @property string|null $created_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_at
 * @property-read Collection<int, Archive> $archives
 * @property-read int|null $archives_count
 * @property-read Orphan $orphan
 * @property-read Tenant $tenant
 *
 * @method static OrphanSponsorshipFactory factory($count = null, $state = [])
 * @method static Builder|OrphanSponsorship newModelQuery()
 * @method static Builder|OrphanSponsorship newQuery()
 * @method static Builder|OrphanSponsorship onlyTrashed()
 * @method static Builder|OrphanSponsorship query()
 * @method static Builder|OrphanSponsorship whereAssociationTrips($value)
 * @method static Builder|OrphanSponsorship whereCreatedAt($value)
 * @method static Builder|OrphanSponsorship whereDeletedAt($value)
 * @method static Builder|OrphanSponsorship whereEidSuit($value)
 * @method static Builder|OrphanSponsorship whereId($value)
 * @method static Builder|OrphanSponsorship whereMedicalSponsorship($value)
 * @method static Builder|OrphanSponsorship whereOrphanId($value)
 * @method static Builder|OrphanSponsorship wherePrivateLessons($value)
 * @method static Builder|OrphanSponsorship whereSchoolBag($value)
 * @method static Builder|OrphanSponsorship whereSummerCamp($value)
 * @method static Builder|OrphanSponsorship whereTenantId($value)
 * @method static Builder|OrphanSponsorship whereUniversityScholarship($value)
 * @method static Builder|OrphanSponsorship whereUpdatedAt($value)
 * @method static Builder|OrphanSponsorship withTrashed()
 * @method static Builder|OrphanSponsorship withoutTrashed()
 *
 * @mixin Eloquent
 */
class OrphanSponsorship extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'orphan_id',
        'medical_sponsorship',
        'university_scholarship',
        'association_trips',
        'summer_camp',
        'eid_suit',
        'private_lessons',
        'school_bag',
    ];

    protected $table = 'orphan_sponsorship';

    public function orphan(): BelongsTo
    {
        return $this->belongsTo(Orphan::class);
    }

    public function searchableAs(): string
    {
        return 'orphan_sponsorships';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(
            'orphan.academicLevel',
            'orphan.sponsor',
            'orphan.family',
            'orphan.family.zone',
            'orphan.lastAcademicYearAchievement'
        );
    }

    public function toSearchableArray(): array
    {
        return [
            'medical_sponsorship' => $this->medical_sponsorship,
            'university_scholarship' => $this->university_scholarship,
            'association_trips' => $this->association_trips,
            'summer_camp' => $this->summer_camp,
            'eid_suit' => $this->eid_suit,
            'private_lessons' => $this->private_lessons,
            'school_bag' => $this->school_bag,
            'family' => [
                'address' => $this->orphan->family?->address,
                'zone' => $this->orphan->family?->zone->name,
            ],
            'orphan' => [
                'id' => $this->orphan->id,
                'gender' => $this->orphan->gender,
                'age' => $this->orphan->birth_date->age ?? null,
                'name' => $this->orphan->getName(),
                'birth_date' => strtotime($this->orphan->birth_date),
                'academic_achievement' => [
                    'academic_level' => $this->orphan->academicLevel,
                    'academic_year' => $this->orphan->lastAcademicYearAchievement?->academic_year,
                    'last_year_average' => (float) $this->orphan->lastAcademicYearAchievement?->average,
                ],
                'year_average' => (float) $this->orphan?->lastAcademicYearAchievement?->average,
                'shirt_size' => $this->orphan->shirt_size,
                'pants_size' => $this->orphan->pants_size,
                'shoes_size' => $this->orphan->shoes_size,
            ],
            'sponsor' => [
                'name' => $this->orphan->sponsor?->getName(),
                'phone_number' => $this->orphan->sponsor?->formattedPhoneNumber(),
            ],
            'tenant_id' => $this->orphan->tenant_id,
        ];
    }

    public function archives(): MorphToMany
    {
        return $this->morphToMany(Archive::class, 'archiveable');
    }
}
