<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property string $id
     * @property int $i_id
     * @property string $level
     * @property string $phase
     * @property string|null $phase_key
     * @property array<array-key, mixed>|null $subject_ids
     * @property-read Collection<int, AcademicLevelSchoolTool> $AcademicLevelSchoolTools
     * @property-read int|null $academic_level_school_tools_count
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     * @property-read Collection<int, Transcript> $transcripts
     * @property-read int|null $transcripts_count
     *
     * @method static Builder<static>|AcademicLevel newModelQuery()
     * @method static Builder<static>|AcademicLevel newQuery()
     * @method static Builder<static>|AcademicLevel query()
     * @method static Builder<static>|AcademicLevel whereIId($value)
     * @method static Builder<static>|AcademicLevel whereId($value)
     * @method static Builder<static>|AcademicLevel whereLevel($value)
     * @method static Builder<static>|AcademicLevel wherePhase($value)
     * @method static Builder<static>|AcademicLevel wherePhaseKey($value)
     * @method static Builder<static>|AcademicLevel whereSubjectIds($value)
     */
    class AcademicLevel extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property int $qty
     * @property string $academic_level_id
     * @property int $school_tool_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read AcademicLevel $academicLevel
     * @property-read SchoolTool|null $schoolTool
     *
     * @method static Builder<static>|AcademicLevelSchoolTool newModelQuery()
     * @method static Builder<static>|AcademicLevelSchoolTool newQuery()
     * @method static Builder<static>|AcademicLevelSchoolTool query()
     * @method static Builder<static>|AcademicLevelSchoolTool whereAcademicLevelId($value)
     * @method static Builder<static>|AcademicLevelSchoolTool whereCreatedAt($value)
     * @method static Builder<static>|AcademicLevelSchoolTool whereId($value)
     * @method static Builder<static>|AcademicLevelSchoolTool whereQty($value)
     * @method static Builder<static>|AcademicLevelSchoolTool whereSchoolToolId($value)
     * @method static Builder<static>|AcademicLevelSchoolTool whereUpdatedAt($value)
     */
    class AcademicLevelSchoolTool extends Eloquent {}
}

namespace App\Models{use Database\Factories\ArchiveFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $tenant_id
     * @property string $saved_by
     * @property string $occasion
     * @property array<array-key, mixed>|null $metadata
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, Baby> $babies
     * @property-read int|null $babies_count
     * @property-read Collection<int, Family> $families
     * @property-read int|null $families_count
     * @property-read Collection<int, Baby> $listBabies
     * @property-read int|null $list_babies_count
     * @property-read Collection<int, Family> $listFamilies
     * @property-read int|null $list_families_count
     * @property-read Collection<int, Orphan> $listOrphans
     * @property-read int|null $list_orphans_count
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     * @property-read User $savedBy
     * @property-read Tenant $tenant
     *
     * @method static ArchiveFactory factory($count = null, $state = [])
     * @method static Builder<static>|Archive newModelQuery()
     * @method static Builder<static>|Archive newQuery()
     * @method static Builder<static>|Archive query()
     * @method static Builder<static>|Archive whereCreatedAt($value)
     * @method static Builder<static>|Archive whereId($value)
     * @method static Builder<static>|Archive whereMetadata($value)
     * @method static Builder<static>|Archive whereOccasion($value)
     * @method static Builder<static>|Archive whereSavedBy($value)
     * @method static Builder<static>|Archive whereTenantId($value)
     * @method static Builder<static>|Archive whereUpdatedAt($value)
     */
    class Archive extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property string $archive_id
     * @property string $archiveable_id
     * @property string $archiveable_type
     * @property string $tenant_id
     * @property-read Tenant $tenant
     *
     * @method static Builder<static>|Archiveable newModelQuery()
     * @method static Builder<static>|Archiveable newQuery()
     * @method static Builder<static>|Archiveable query()
     * @method static Builder<static>|Archiveable whereArchiveId($value)
     * @method static Builder<static>|Archiveable whereArchiveableId($value)
     * @method static Builder<static>|Archiveable whereArchiveableType($value)
     * @method static Builder<static>|Archiveable whereTenantId($value)
     */
    class Archiveable extends Eloquent {}
}

namespace App\Models{use Database\Factories\BabyFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property int|null $baby_milk_quantity
     * @property string|null $baby_milk_type
     * @property int|null $diapers_quantity
     * @property string|null $diapers_type
     * @property string $orphan_id
     * @property string $family_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read Collection<int, Archive> $archives
     * @property-read int|null $archives_count
     * @property-read Inventory|null $babyMilk
     * @property-read Inventory|null $diapers
     * @property-read Orphan $orphan
     * @property-read Tenant $tenant
     *
     * @method static BabyFactory factory($count = null, $state = [])
     * @method static Builder<static>|Baby newModelQuery()
     * @method static Builder<static>|Baby newQuery()
     * @method static Builder<static>|Baby onlyTrashed()
     * @method static Builder<static>|Baby query()
     * @method static Builder<static>|Baby whereBabyMilkQuantity($value)
     * @method static Builder<static>|Baby whereBabyMilkType($value)
     * @method static Builder<static>|Baby whereCreatedAt($value)
     * @method static Builder<static>|Baby whereDeletedAt($value)
     * @method static Builder<static>|Baby whereDiapersQuantity($value)
     * @method static Builder<static>|Baby whereDiapersType($value)
     * @method static Builder<static>|Baby whereFamilyId($value)
     * @method static Builder<static>|Baby whereId($value)
     * @method static Builder<static>|Baby whereOrphanId($value)
     * @method static Builder<static>|Baby whereTenantId($value)
     * @method static Builder<static>|Baby whereUpdatedAt($value)
     * @method static Builder<static>|Baby withTrashed()
     * @method static Builder<static>|Baby withoutTrashed()
     */
    class Baby extends Eloquent {}
}

namespace App\Models{use Database\Factories\BenefactorFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $first_name
     * @property string $last_name
     * @property string|null $phone
     * @property string|null $address
     * @property array<array-key, mixed>|null $location
     * @property string $created_by
     * @property string|null $deleted_by
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read User|null $creator
     * @property-read Collection<int, Sponsorship> $sponsorships
     * @property-read int|null $sponsorships_count
     * @property-read Tenant|null $tenant
     *
     * @method static BenefactorFactory factory($count = null, $state = [])
     * @method static Builder<static>|Benefactor newModelQuery()
     * @method static Builder<static>|Benefactor newQuery()
     * @method static Builder<static>|Benefactor onlyTrashed()
     * @method static Builder<static>|Benefactor query()
     * @method static Builder<static>|Benefactor whereAddress($value)
     * @method static Builder<static>|Benefactor whereCreatedAt($value)
     * @method static Builder<static>|Benefactor whereCreatedBy($value)
     * @method static Builder<static>|Benefactor whereDeletedAt($value)
     * @method static Builder<static>|Benefactor whereDeletedBy($value)
     * @method static Builder<static>|Benefactor whereFirstName($value)
     * @method static Builder<static>|Benefactor whereId($value)
     * @method static Builder<static>|Benefactor whereLastName($value)
     * @method static Builder<static>|Benefactor whereLocation($value)
     * @method static Builder<static>|Benefactor wherePhone($value)
     * @method static Builder<static>|Benefactor whereTenantId($value)
     * @method static Builder<static>|Benefactor whereUpdatedAt($value)
     * @method static Builder<static>|Benefactor withTrashed()
     * @method static Builder<static>|Benefactor withoutTrashed()
     */
    class Benefactor extends Eloquent {}
}

namespace App\Models{use Database\Factories\BranchFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string $tenant_id
     * @property int $city_id
     * @property string $president_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property string $created_by
     * @property string|null $deleted_by
     * @property-read City $city
     * @property-read User $creator
     * @property-read Collection<int, Family> $families
     * @property-read int|null $families_count
     * @property-read Collection<int, User> $members
     * @property-read int|null $members_count
     * @property-read User $president
     * @property-read Tenant $tenant
     *
     * @method static BranchFactory factory($count = null, $state = [])
     * @method static Builder<static>|Branch newModelQuery()
     * @method static Builder<static>|Branch newQuery()
     * @method static Builder<static>|Branch onlyTrashed()
     * @method static Builder<static>|Branch query()
     * @method static Builder<static>|Branch whereCityId($value)
     * @method static Builder<static>|Branch whereCreatedAt($value)
     * @method static Builder<static>|Branch whereCreatedBy($value)
     * @method static Builder<static>|Branch whereDeletedAt($value)
     * @method static Builder<static>|Branch whereDeletedBy($value)
     * @method static Builder<static>|Branch whereId($value)
     * @method static Builder<static>|Branch whereName($value)
     * @method static Builder<static>|Branch wherePresidentId($value)
     * @method static Builder<static>|Branch whereTenantId($value)
     * @method static Builder<static>|Branch whereUpdatedAt($value)
     * @method static Builder<static>|Branch withTrashed()
     * @method static Builder<static>|Branch withoutTrashed()
     */
    class Branch extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property int $id
     * @property string $commune_name
     * @property string $commune_name_ascii
     * @property string $daira_name
     * @property string $daira_name_ascii
     * @property string $wilaya_code
     * @property string $wilaya_name
     * @property string $wilaya_name_ascii
     * @property string $latitude
     * @property string $longitude
     * @property string $post_code
     * @property string|null $commune_code
     *
     * @method static Builder<static>|City newModelQuery()
     * @method static Builder<static>|City newQuery()
     * @method static Builder<static>|City query()
     * @method static Builder<static>|City whereCommuneCode($value)
     * @method static Builder<static>|City whereCommuneName($value)
     * @method static Builder<static>|City whereCommuneNameAscii($value)
     * @method static Builder<static>|City whereDairaName($value)
     * @method static Builder<static>|City whereDairaNameAscii($value)
     * @method static Builder<static>|City whereId($value)
     * @method static Builder<static>|City whereLatitude($value)
     * @method static Builder<static>|City whereLongitude($value)
     * @method static Builder<static>|City wherePostCode($value)
     * @method static Builder<static>|City whereWilayaCode($value)
     * @method static Builder<static>|City whereWilayaName($value)
     * @method static Builder<static>|City whereWilayaNameAscii($value)
     */
    class City extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property int $id
     * @property string|null $label
     *
     * @method static Builder<static>|ClothesSize newModelQuery()
     * @method static Builder<static>|ClothesSize newQuery()
     * @method static Builder<static>|ClothesSize query()
     * @method static Builder<static>|ClothesSize whereId($value)
     * @method static Builder<static>|ClothesSize whereLabel($value)
     */
    class ClothesSize extends Eloquent {}
}

namespace App\Models{use Database\Factories\CommitteeFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string $description
     * @property string $created_by
     * @property string|null $deleted_by
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read User|null $creator
     * @property-read CommitteeUser|null $pivot
     * @property-read Collection<int, User> $members
     * @property-read int|null $members_count
     * @property-read Tenant|null $tenant
     *
     * @method static CommitteeFactory factory($count = null, $state = [])
     * @method static Builder<static>|Committee newModelQuery()
     * @method static Builder<static>|Committee newQuery()
     * @method static Builder<static>|Committee onlyTrashed()
     * @method static Builder<static>|Committee query()
     * @method static Builder<static>|Committee whereCreatedAt($value)
     * @method static Builder<static>|Committee whereCreatedBy($value)
     * @method static Builder<static>|Committee whereDeletedAt($value)
     * @method static Builder<static>|Committee whereDeletedBy($value)
     * @method static Builder<static>|Committee whereDescription($value)
     * @method static Builder<static>|Committee whereId($value)
     * @method static Builder<static>|Committee whereName($value)
     * @method static Builder<static>|Committee whereTenantId($value)
     * @method static Builder<static>|Committee whereUpdatedAt($value)
     * @method static Builder<static>|Committee withTrashed()
     * @method static Builder<static>|Committee withoutTrashed()
     */
    class Committee extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property string $id
     * @property string $user_id
     * @property string $committee_id
     * @property string $tenant_id
     * @property-read Tenant $tenant
     *
     * @method static Builder<static>|CommitteeUser newModelQuery()
     * @method static Builder<static>|CommitteeUser newQuery()
     * @method static Builder<static>|CommitteeUser query()
     * @method static Builder<static>|CommitteeUser whereCommitteeId($value)
     * @method static Builder<static>|CommitteeUser whereId($value)
     * @method static Builder<static>|CommitteeUser whereTenantId($value)
     * @method static Builder<static>|CommitteeUser whereUserId($value)
     */
    class CommitteeUser extends Eloquent {}
}

namespace App\Models{use Database\Factories\CompetenceFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Tenant|null $tenant
     *
     * @method static CompetenceFactory factory($count = null, $state = [])
     * @method static Builder<static>|Competence newModelQuery()
     * @method static Builder<static>|Competence newQuery()
     * @method static Builder<static>|Competence query()
     * @method static Builder<static>|Competence whereCreatedAt($value)
     * @method static Builder<static>|Competence whereId($value)
     * @method static Builder<static>|Competence whereName($value)
     * @method static Builder<static>|Competence whereTenantId($value)
     * @method static Builder<static>|Competence whereUpdatedAt($value)
     */
    class Competence extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property string $id
     * @property string $user_id
     * @property string $competence_id
     * @property string $tenant_id
     * @property-read Tenant $tenant
     *
     * @method static Builder<static>|CompetenceUser newModelQuery()
     * @method static Builder<static>|CompetenceUser newQuery()
     * @method static Builder<static>|CompetenceUser query()
     * @method static Builder<static>|CompetenceUser whereCompetenceId($value)
     * @method static Builder<static>|CompetenceUser whereId($value)
     * @method static Builder<static>|CompetenceUser whereTenantId($value)
     * @method static Builder<static>|CompetenceUser whereUserId($value)
     */
    class CompetenceUser extends Eloquent {}
}

namespace App\Models{use Database\Factories\DomainFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $domain
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Tenant $tenant
     *
     * @method static DomainFactory factory($count = null, $state = [])
     * @method static Builder<static>|Domain newModelQuery()
     * @method static Builder<static>|Domain newQuery()
     * @method static Builder<static>|Domain query()
     * @method static Builder<static>|Domain whereCreatedAt($value)
     * @method static Builder<static>|Domain whereDomain($value)
     * @method static Builder<static>|Domain whereId($value)
     * @method static Builder<static>|Domain whereTenantId($value)
     * @method static Builder<static>|Domain whereUpdatedAt($value)
     */
    class Domain extends Eloquent {}
}

namespace App\Models{use Database\Factories\EventFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $title
     * @property string $lesson_id
     * @property Carbon $start_date
     * @property Carbon $end_date
     * @property string|null $frequency
     * @property int|null $interval
     * @property string|null $until
     * @property string|null $color
     * @property string $tenant_id
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string $created_by
     * @property string|null $deleted_by
     * @property-read User $creator
     * @property-read Collection<int, EventOccurrence> $occurrences
     * @property-read int|null $occurrences_count
     * @property-read PrivateSchool|null $school
     * @property-read Subject|null $subject
     * @property-read Tenant $tenant
     *
     * @method static EventFactory factory($count = null, $state = [])
     * @method static Builder<static>|Event newModelQuery()
     * @method static Builder<static>|Event newQuery()
     * @method static Builder<static>|Event onlyTrashed()
     * @method static Builder<static>|Event query()
     * @method static Builder<static>|Event whereColor($value)
     * @method static Builder<static>|Event whereCreatedAt($value)
     * @method static Builder<static>|Event whereCreatedBy($value)
     * @method static Builder<static>|Event whereDeletedAt($value)
     * @method static Builder<static>|Event whereDeletedBy($value)
     * @method static Builder<static>|Event whereEndDate($value)
     * @method static Builder<static>|Event whereFrequency($value)
     * @method static Builder<static>|Event whereId($value)
     * @method static Builder<static>|Event whereInterval($value)
     * @method static Builder<static>|Event whereLessonId($value)
     * @method static Builder<static>|Event whereStartDate($value)
     * @method static Builder<static>|Event whereTenantId($value)
     * @method static Builder<static>|Event whereTitle($value)
     * @method static Builder<static>|Event whereUntil($value)
     * @method static Builder<static>|Event whereUpdatedAt($value)
     * @method static Builder<static>|Event withTrashed()
     * @method static Builder<static>|Event withoutTrashed()
     */
    class Event extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $start_date
     * @property string $end_date
     * @property string $lesson_id
     * @property string $event_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read Event $event
     * @property-read Lesson $lesson
     * @property-read EventOccurrenceOrphan|null $pivot
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     * @property-read Tenant $tenant
     *
     * @method static Builder<static>|EventOccurrence newModelQuery()
     * @method static Builder<static>|EventOccurrence newQuery()
     * @method static Builder<static>|EventOccurrence onlyTrashed()
     * @method static Builder<static>|EventOccurrence query()
     * @method static Builder<static>|EventOccurrence whereCreatedAt($value)
     * @method static Builder<static>|EventOccurrence whereDeletedAt($value)
     * @method static Builder<static>|EventOccurrence whereEndDate($value)
     * @method static Builder<static>|EventOccurrence whereEventId($value)
     * @method static Builder<static>|EventOccurrence whereId($value)
     * @method static Builder<static>|EventOccurrence whereLessonId($value)
     * @method static Builder<static>|EventOccurrence whereStartDate($value)
     * @method static Builder<static>|EventOccurrence whereTenantId($value)
     * @method static Builder<static>|EventOccurrence whereUpdatedAt($value)
     * @method static Builder<static>|EventOccurrence withTrashed()
     * @method static Builder<static>|EventOccurrence withoutTrashed()
     */
    class EventOccurrence extends Eloquent {}
}

namespace App\Models{use Database\Factories\EventOccurrenceOrphanFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $event_occurrence_id
     * @property string $lesson_id
     * @property string $orphan_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read Tenant $tenant
     *
     * @method static EventOccurrenceOrphanFactory factory($count = null, $state = [])
     * @method static Builder<static>|EventOccurrenceOrphan newModelQuery()
     * @method static Builder<static>|EventOccurrenceOrphan newQuery()
     * @method static Builder<static>|EventOccurrenceOrphan onlyTrashed()
     * @method static Builder<static>|EventOccurrenceOrphan query()
     * @method static Builder<static>|EventOccurrenceOrphan whereCreatedAt($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereDeletedAt($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereEventOccurrenceId($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereId($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereLessonId($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereOrphanId($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereTenantId($value)
     * @method static Builder<static>|EventOccurrenceOrphan whereUpdatedAt($value)
     * @method static Builder<static>|EventOccurrenceOrphan withTrashed()
     * @method static Builder<static>|EventOccurrenceOrphan withoutTrashed()
     */
    class EventOccurrenceOrphan extends Eloquent {}
}

namespace App\Models{use Database\Factories\FamilyFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
     */
    class Family extends Eloquent implements HasMedia {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string|null $status
     * @property string $family_id
     * @property string $updated_by
     * @property string $tenant_id
     * @property string|null $note
     * @property int $year
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Family $family
     * @property-read Tenant $tenant
     *
     * @method static Builder<static>|FamilyEidAlAdha newModelQuery()
     * @method static Builder<static>|FamilyEidAlAdha newQuery()
     * @method static Builder<static>|FamilyEidAlAdha query()
     * @method static Builder<static>|FamilyEidAlAdha whereCreatedAt($value)
     * @method static Builder<static>|FamilyEidAlAdha whereFamilyId($value)
     * @method static Builder<static>|FamilyEidAlAdha whereId($value)
     * @method static Builder<static>|FamilyEidAlAdha whereNote($value)
     * @method static Builder<static>|FamilyEidAlAdha whereStatus($value)
     * @method static Builder<static>|FamilyEidAlAdha whereTenantId($value)
     * @method static Builder<static>|FamilyEidAlAdha whereUpdatedAt($value)
     * @method static Builder<static>|FamilyEidAlAdha whereUpdatedBy($value)
     * @method static Builder<static>|FamilyEidAlAdha whereYear($value)
     */
    class FamilyEidAlAdha extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property string $id
     * @property float $amount
     * @property string $zakat_id
     * @property string $family_id
     * @property string $tenant_id
     * @property-read Collection<int, Family> $families
     * @property-read int|null $families_count
     * @property-read Tenant|null $tenant
     *
     * @method static Builder<static>|FamilyZakat newModelQuery()
     * @method static Builder<static>|FamilyZakat newQuery()
     * @method static Builder<static>|FamilyZakat query()
     * @method static Builder<static>|FamilyZakat whereAmount($value)
     * @method static Builder<static>|FamilyZakat whereFamilyId($value)
     * @method static Builder<static>|FamilyZakat whereId($value)
     * @method static Builder<static>|FamilyZakat whereTenantId($value)
     * @method static Builder<static>|FamilyZakat whereZakatId($value)
     */
    class FamilyZakat extends Eloquent {}
}

namespace App\Models{use Database\Factories\FinanceFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property float $amount
     * @property string|null $description
     * @property Carbon $date
     * @property string $tenant_id
     * @property string $specification
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property string $created_by
     * @property string|null $received_by
     * @property string|null $deleted_by
     * @property-read User $creator
     * @property-read User|null $receiver
     * @property-read Tenant $tenant
     *
     * @method static FinanceFactory factory($count = null, $state = [])
     * @method static Builder<static>|Finance newModelQuery()
     * @method static Builder<static>|Finance newQuery()
     * @method static Builder<static>|Finance onlyTrashed()
     * @method static Builder<static>|Finance query()
     * @method static Builder<static>|Finance whereAmount($value)
     * @method static Builder<static>|Finance whereCreatedAt($value)
     * @method static Builder<static>|Finance whereCreatedBy($value)
     * @method static Builder<static>|Finance whereDate($value)
     * @method static Builder<static>|Finance whereDeletedAt($value)
     * @method static Builder<static>|Finance whereDeletedBy($value)
     * @method static Builder<static>|Finance whereDescription($value)
     * @method static Builder<static>|Finance whereId($value)
     * @method static Builder<static>|Finance whereReceivedBy($value)
     * @method static Builder<static>|Finance whereSpecification($value)
     * @method static Builder<static>|Finance whereTenantId($value)
     * @method static Builder<static>|Finance whereUpdatedAt($value)
     * @method static Builder<static>|Finance withTrashed()
     * @method static Builder<static>|Finance withoutTrashed()
     */
    class Finance extends Eloquent {}
}

namespace App\Models{use Database\Factories\FurnishingFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property array<array-key, mixed>|null $television
     * @property array<array-key, mixed>|null $refrigerator
     * @property array<array-key, mixed>|null $fireplace
     * @property array<array-key, mixed>|null $washing_machine
     * @property array<array-key, mixed>|null $water_heater
     * @property array<array-key, mixed>|null $oven
     * @property array<array-key, mixed>|null $wardrobe
     * @property array<array-key, mixed>|null $cupboard
     * @property array<array-key, mixed>|null $covers
     * @property array<array-key, mixed>|null $mattresses
     * @property array<array-key, mixed>|null $other_furnishings
     * @property string $family_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Family $family
     * @property-read Tenant $tenant
     *
     * @method static FurnishingFactory factory($count = null, $state = [])
     * @method static Builder<static>|Furnishing newModelQuery()
     * @method static Builder<static>|Furnishing newQuery()
     * @method static Builder<static>|Furnishing query()
     * @method static Builder<static>|Furnishing whereCovers($value)
     * @method static Builder<static>|Furnishing whereCreatedAt($value)
     * @method static Builder<static>|Furnishing whereCupboard($value)
     * @method static Builder<static>|Furnishing whereFamilyId($value)
     * @method static Builder<static>|Furnishing whereFireplace($value)
     * @method static Builder<static>|Furnishing whereId($value)
     * @method static Builder<static>|Furnishing whereMattresses($value)
     * @method static Builder<static>|Furnishing whereOtherFurnishings($value)
     * @method static Builder<static>|Furnishing whereOven($value)
     * @method static Builder<static>|Furnishing whereRefrigerator($value)
     * @method static Builder<static>|Furnishing whereTelevision($value)
     * @method static Builder<static>|Furnishing whereTenantId($value)
     * @method static Builder<static>|Furnishing whereUpdatedAt($value)
     * @method static Builder<static>|Furnishing whereWardrobe($value)
     * @method static Builder<static>|Furnishing whereWashingMachine($value)
     * @method static Builder<static>|Furnishing whereWaterHeater($value)
     */
    class Furnishing extends Eloquent {}
}

namespace App\Models{use Database\Factories\HousingFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string|null $value
     * @property string|null $housing_receipt_number
     * @property int|null $number_of_rooms
     * @property string|null $other_properties
     * @property string $family_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Family $family
     * @property-read Tenant $tenant
     *
     * @method static HousingFactory factory($count = null, $state = [])
     * @method static Builder<static>|Housing newModelQuery()
     * @method static Builder<static>|Housing newQuery()
     * @method static Builder<static>|Housing query()
     * @method static Builder<static>|Housing whereCreatedAt($value)
     * @method static Builder<static>|Housing whereFamilyId($value)
     * @method static Builder<static>|Housing whereHousingReceiptNumber($value)
     * @method static Builder<static>|Housing whereId($value)
     * @method static Builder<static>|Housing whereName($value)
     * @method static Builder<static>|Housing whereNumberOfRooms($value)
     * @method static Builder<static>|Housing whereOtherProperties($value)
     * @method static Builder<static>|Housing whereTenantId($value)
     * @method static Builder<static>|Housing whereUpdatedAt($value)
     * @method static Builder<static>|Housing whereValue($value)
     */
    class Housing extends Eloquent {}
}

namespace App\Models{use Database\Factories\IncomeFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

    /**
     * @property string $id
     * @property bool|null $cnr
     * @property bool|null $cnas
     * @property bool|null $casnos
     * @property bool|null $pension
     * @property array<array-key, mixed> $account
     * @property float|null $other_income
     * @property float|null $total_income
     * @property string $sponsor_id
     * @property string $tenant_id
     * @property-read MediaCollection<int, Media> $media
     * @property-read int|null $media_count
     * @property-read Sponsor $sponsor
     * @property-read Tenant $tenant
     *
     * @method static IncomeFactory factory($count = null, $state = [])
     * @method static Builder<static>|Income newModelQuery()
     * @method static Builder<static>|Income newQuery()
     * @method static Builder<static>|Income query()
     * @method static Builder<static>|Income whereAccount($value)
     * @method static Builder<static>|Income whereCasnos($value)
     * @method static Builder<static>|Income whereCnas($value)
     * @method static Builder<static>|Income whereCnr($value)
     * @method static Builder<static>|Income whereId($value)
     * @method static Builder<static>|Income whereOtherIncome($value)
     * @method static Builder<static>|Income wherePension($value)
     * @method static Builder<static>|Income whereSponsorId($value)
     * @method static Builder<static>|Income whereTenantId($value)
     * @method static Builder<static>|Income whereTotalIncome($value)
     */
    class Income extends Eloquent implements HasMedia {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $institutionable_type
     * @property int $institutionable_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Model|Eloquent $institutionable
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     * @property-read Tenant|null $tenant
     *
     * @method static Builder<static>|Institution newModelQuery()
     * @method static Builder<static>|Institution newQuery()
     * @method static Builder<static>|Institution query()
     * @method static Builder<static>|Institution whereCreatedAt($value)
     * @method static Builder<static>|Institution whereId($value)
     * @method static Builder<static>|Institution whereInstitutionableId($value)
     * @method static Builder<static>|Institution whereInstitutionableType($value)
     * @method static Builder<static>|Institution whereUpdatedAt($value)
     */
    class Institution extends Eloquent {}
}

namespace App\Models{use Database\Factories\InventoryFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property int|null $qty
     * @property string|null $unit
     * @property string|null $type
     * @property string|null $note
     * @property string $created_by
     * @property string|null $deleted_by
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read User $creator
     * @property-read Tenant $tenant
     *
     * @method static InventoryFactory factory($count = null, $state = [])
     * @method static Builder<static>|Inventory newModelQuery()
     * @method static Builder<static>|Inventory newQuery()
     * @method static Builder<static>|Inventory onlyTrashed()
     * @method static Builder<static>|Inventory query()
     * @method static Builder<static>|Inventory whereCreatedAt($value)
     * @method static Builder<static>|Inventory whereCreatedBy($value)
     * @method static Builder<static>|Inventory whereDeletedAt($value)
     * @method static Builder<static>|Inventory whereDeletedBy($value)
     * @method static Builder<static>|Inventory whereId($value)
     * @method static Builder<static>|Inventory whereName($value)
     * @method static Builder<static>|Inventory whereNote($value)
     * @method static Builder<static>|Inventory whereQty($value)
     * @method static Builder<static>|Inventory whereTenantId($value)
     * @method static Builder<static>|Inventory whereType($value)
     * @method static Builder<static>|Inventory whereUnit($value)
     * @method static Builder<static>|Inventory whereUpdatedAt($value)
     * @method static Builder<static>|Inventory withTrashed()
     * @method static Builder<static>|Inventory withoutTrashed()
     */
    class Inventory extends Eloquent {}
}

namespace App\Models{use Database\Factories\LessonFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property int $subject_id
     * @property string $academic_level_id
     * @property string $private_school_id
     * @property int $quota
     * @property string|null $start_date
     * @property string|null $end_date
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read AcademicLevel|null $academicLevel
     * @property-read Collection<int, EventOccurrence> $orphans
     * @property-read int|null $orphans_count
     * @property-read PrivateSchool $school
     * @property-read Subject|null $subject
     * @property-read Tenant $tenant
     *
     * @method static LessonFactory factory($count = null, $state = [])
     * @method static Builder<static>|Lesson newModelQuery()
     * @method static Builder<static>|Lesson newQuery()
     * @method static Builder<static>|Lesson onlyTrashed()
     * @method static Builder<static>|Lesson query()
     * @method static Builder<static>|Lesson whereAcademicLevelId($value)
     * @method static Builder<static>|Lesson whereCreatedAt($value)
     * @method static Builder<static>|Lesson whereDeletedAt($value)
     * @method static Builder<static>|Lesson whereEndDate($value)
     * @method static Builder<static>|Lesson whereId($value)
     * @method static Builder<static>|Lesson wherePrivateSchoolId($value)
     * @method static Builder<static>|Lesson whereQuota($value)
     * @method static Builder<static>|Lesson whereStartDate($value)
     * @method static Builder<static>|Lesson whereSubjectId($value)
     * @method static Builder<static>|Lesson whereTenantId($value)
     * @method static Builder<static>|Lesson whereUpdatedAt($value)
     * @method static Builder<static>|Lesson withTrashed()
     * @method static Builder<static>|Lesson withoutTrashed()
     */
    class Lesson extends Eloquent {}
}

namespace App\Models{use Database\Factories\MemberPreviewFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property string $id
     * @property string $user_id
     * @property string $tenant_id
     * @property string $preview_id
     * @property-read Tenant $tenant
     *
     * @method static MemberPreviewFactory factory($count = null, $state = [])
     * @method static Builder<static>|MemberPreview newModelQuery()
     * @method static Builder<static>|MemberPreview newQuery()
     * @method static Builder<static>|MemberPreview query()
     * @method static Builder<static>|MemberPreview whereId($value)
     * @method static Builder<static>|MemberPreview wherePreviewId($value)
     * @method static Builder<static>|MemberPreview whereTenantId($value)
     * @method static Builder<static>|MemberPreview whereUserId($value)
     */
    class MemberPreview extends Eloquent {}
}

namespace App\Models{use Database\Factories\MonthlyBasketFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property int $qty_for_family
     * @property bool $status
     * @property string $tenant_id
     * @property string $inventory_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Inventory $inventory
     * @property-read Tenant $tenant
     *
     * @method static MonthlyBasketFactory factory($count = null, $state = [])
     * @method static Builder<static>|MonthlyBasket newModelQuery()
     * @method static Builder<static>|MonthlyBasket newQuery()
     * @method static Builder<static>|MonthlyBasket query()
     * @method static Builder<static>|MonthlyBasket whereCreatedAt($value)
     * @method static Builder<static>|MonthlyBasket whereId($value)
     * @method static Builder<static>|MonthlyBasket whereInventoryId($value)
     * @method static Builder<static>|MonthlyBasket whereQtyForFamily($value)
     * @method static Builder<static>|MonthlyBasket whereStatus($value)
     * @method static Builder<static>|MonthlyBasket whereTenantId($value)
     * @method static Builder<static>|MonthlyBasket whereUpdatedAt($value)
     */
    class MonthlyBasket extends Eloquent {}
}

namespace App\Models{use Database\Factories\NeedFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $demand
     * @property string $subject
     * @property string $status
     * @property string $needable_type
     * @property string $needable_id
     * @property string $tenant_id
     * @property string|null $note
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string|null $created_by
     * @property string|null $deleted_by
     * @property-read User|null $creator
     * @property-read Model|Eloquent $needable
     * @property-read Tenant $tenant
     *
     * @method static NeedFactory factory($count = null, $state = [])
     * @method static Builder<static>|Need newModelQuery()
     * @method static Builder<static>|Need newQuery()
     * @method static Builder<static>|Need onlyTrashed()
     * @method static Builder<static>|Need query()
     * @method static Builder<static>|Need whereCreatedAt($value)
     * @method static Builder<static>|Need whereCreatedBy($value)
     * @method static Builder<static>|Need whereDeletedAt($value)
     * @method static Builder<static>|Need whereDeletedBy($value)
     * @method static Builder<static>|Need whereDemand($value)
     * @method static Builder<static>|Need whereId($value)
     * @method static Builder<static>|Need whereNeedableId($value)
     * @method static Builder<static>|Need whereNeedableType($value)
     * @method static Builder<static>|Need whereNote($value)
     * @method static Builder<static>|Need whereStatus($value)
     * @method static Builder<static>|Need whereSubject($value)
     * @method static Builder<static>|Need whereTenantId($value)
     * @method static Builder<static>|Need whereUpdatedAt($value)
     * @method static Builder<static>|Need withTrashed()
     * @method static Builder<static>|Need withoutTrashed()
     */
    class Need extends Eloquent {}
}

namespace App\Models{use Database\Factories\OrphanFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
     */
    class Orphan extends Eloquent implements HasMedia {}
}

namespace App\Models{use Database\Factories\OrphanEidSuitFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $tenant_id
     * @property string $orphan_id
     * @property string|null $note
     * @property string|null $clothes_shop_name
     * @property string|null $clothes_shop_phone_number
     * @property string|null $shoes_shop_name
     * @property string|null $shoes_shop_phone_number
     * @property string|null $user_id
     * @property string|null $shoes_shop_address
     * @property array<array-key, mixed>|null $shoes_shop_location
     * @property string|null $clothes_shop_address
     * @property array<array-key, mixed>|null $clothes_shop_location
     * @property bool|null $shirt_completed
     * @property bool|null $shoes_completed
     * @property bool|null $pants_completed
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read User|null $member
     * @property-read Orphan|null $orphan
     * @property-read Tenant|null $tenant
     *
     * @method static OrphanEidSuitFactory factory($count = null, $state = [])
     * @method static Builder<static>|OrphanEidSuit newModelQuery()
     * @method static Builder<static>|OrphanEidSuit newQuery()
     * @method static Builder<static>|OrphanEidSuit query()
     * @method static Builder<static>|OrphanEidSuit whereClothesShopAddress($value)
     * @method static Builder<static>|OrphanEidSuit whereClothesShopLocation($value)
     * @method static Builder<static>|OrphanEidSuit whereClothesShopName($value)
     * @method static Builder<static>|OrphanEidSuit whereClothesShopPhoneNumber($value)
     * @method static Builder<static>|OrphanEidSuit whereCreatedAt($value)
     * @method static Builder<static>|OrphanEidSuit whereId($value)
     * @method static Builder<static>|OrphanEidSuit whereNote($value)
     * @method static Builder<static>|OrphanEidSuit whereOrphanId($value)
     * @method static Builder<static>|OrphanEidSuit wherePantsCompleted($value)
     * @method static Builder<static>|OrphanEidSuit whereShirtCompleted($value)
     * @method static Builder<static>|OrphanEidSuit whereShoesCompleted($value)
     * @method static Builder<static>|OrphanEidSuit whereShoesShopAddress($value)
     * @method static Builder<static>|OrphanEidSuit whereShoesShopLocation($value)
     * @method static Builder<static>|OrphanEidSuit whereShoesShopName($value)
     * @method static Builder<static>|OrphanEidSuit whereShoesShopPhoneNumber($value)
     * @method static Builder<static>|OrphanEidSuit whereTenantId($value)
     * @method static Builder<static>|OrphanEidSuit whereUpdatedAt($value)
     * @method static Builder<static>|OrphanEidSuit whereUserId($value)
     */
    class OrphanEidSuit extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $uuid
     * @property string $name
     * @property string $guard_name
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read Collection<int, Role> $roles
     * @property-read int|null $roles_count
     * @property-read Collection<int, User> $users
     * @property-read int|null $users_count
     *
     * @method static Builder<static>|Permission newModelQuery()
     * @method static Builder<static>|Permission newQuery()
     * @method static Builder<static>|Permission permission($permissions, $without = false)
     * @method static Builder<static>|Permission query()
     * @method static Builder<static>|Permission role($roles, $guard = null, $without = false)
     * @method static Builder<static>|Permission whereCreatedAt($value)
     * @method static Builder<static>|Permission whereGuardName($value)
     * @method static Builder<static>|Permission whereName($value)
     * @method static Builder<static>|Permission whereUpdatedAt($value)
     * @method static Builder<static>|Permission whereUuid($value)
     * @method static Builder<static>|Permission withoutPermission($permissions)
     * @method static Builder<static>|Permission withoutRole($roles, $guard = null)
     */
    class Permission extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $tokenable_type
     * @property string $tokenable_id
     * @property string $name
     * @property string $token
     * @property array<array-key, mixed>|null $abilities
     * @property Carbon|null $last_used_at
     * @property Carbon|null $expires_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Model|Eloquent $tokenable
     *
     * @method static Builder<static>|PersonalAccessToken newModelQuery()
     * @method static Builder<static>|PersonalAccessToken newQuery()
     * @method static Builder<static>|PersonalAccessToken query()
     * @method static Builder<static>|PersonalAccessToken whereAbilities($value)
     * @method static Builder<static>|PersonalAccessToken whereCreatedAt($value)
     * @method static Builder<static>|PersonalAccessToken whereExpiresAt($value)
     * @method static Builder<static>|PersonalAccessToken whereId($value)
     * @method static Builder<static>|PersonalAccessToken whereLastUsedAt($value)
     * @method static Builder<static>|PersonalAccessToken whereName($value)
     * @method static Builder<static>|PersonalAccessToken whereToken($value)
     * @method static Builder<static>|PersonalAccessToken whereTokenableId($value)
     * @method static Builder<static>|PersonalAccessToken whereTokenableType($value)
     * @method static Builder<static>|PersonalAccessToken whereUpdatedAt($value)
     */
    class PersonalAccessToken extends Eloquent {}
}

namespace App\Models{use Database\Factories\PreviewFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $report
     * @property Carbon $preview_date
     * @property string $family_id
     * @property string $tenant_id
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Family|null $family
     * @property-read MemberPreview|null $pivot
     * @property-read Collection<int, User> $inspectors
     * @property-read int|null $inspectors_count
     * @property-read Tenant|null $tenant
     *
     * @method static PreviewFactory factory($count = null, $state = [])
     * @method static Builder<static>|Preview newModelQuery()
     * @method static Builder<static>|Preview newQuery()
     * @method static Builder<static>|Preview onlyTrashed()
     * @method static Builder<static>|Preview query()
     * @method static Builder<static>|Preview whereCreatedAt($value)
     * @method static Builder<static>|Preview whereDeletedAt($value)
     * @method static Builder<static>|Preview whereFamilyId($value)
     * @method static Builder<static>|Preview whereId($value)
     * @method static Builder<static>|Preview wherePreviewDate($value)
     * @method static Builder<static>|Preview whereReport($value)
     * @method static Builder<static>|Preview whereTenantId($value)
     * @method static Builder<static>|Preview whereUpdatedAt($value)
     * @method static Builder<static>|Preview withTrashed()
     * @method static Builder<static>|Preview withoutTrashed()
     */
    class Preview extends Eloquent {}
}

namespace App\Models{use Database\Factories\PrivateSchoolFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string $tenant_id
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string $created_by
     * @property string|null $deleted_by
     * @property-read User $creator
     * @property-read Collection<int, EventOccurrence> $eventsWithOrphans
     * @property-read int|null $events_with_orphans_count
     * @property-read Collection<int, Lesson> $lessons
     * @property-read int|null $lessons_count
     * @property-read Tenant $tenant
     *
     * @method static PrivateSchoolFactory factory($count = null, $state = [])
     * @method static Builder<static>|PrivateSchool newModelQuery()
     * @method static Builder<static>|PrivateSchool newQuery()
     * @method static Builder<static>|PrivateSchool onlyTrashed()
     * @method static Builder<static>|PrivateSchool query()
     * @method static Builder<static>|PrivateSchool whereCreatedAt($value)
     * @method static Builder<static>|PrivateSchool whereCreatedBy($value)
     * @method static Builder<static>|PrivateSchool whereDeletedAt($value)
     * @method static Builder<static>|PrivateSchool whereDeletedBy($value)
     * @method static Builder<static>|PrivateSchool whereId($value)
     * @method static Builder<static>|PrivateSchool whereName($value)
     * @method static Builder<static>|PrivateSchool whereTenantId($value)
     * @method static Builder<static>|PrivateSchool whereUpdatedAt($value)
     * @method static Builder<static>|PrivateSchool withTrashed()
     * @method static Builder<static>|PrivateSchool withoutTrashed()
     */
    class PrivateSchool extends Eloquent {}
}

namespace App\Models{use Database\Factories\RamadanBasketFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property int $qty_for_family
     * @property bool $status
     * @property string $inventory_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Inventory $inventory
     * @property-read Tenant $tenant
     *
     * @method static RamadanBasketFactory factory($count = null, $state = [])
     * @method static Builder<static>|RamadanBasket newModelQuery()
     * @method static Builder<static>|RamadanBasket newQuery()
     * @method static Builder<static>|RamadanBasket query()
     * @method static Builder<static>|RamadanBasket whereCreatedAt($value)
     * @method static Builder<static>|RamadanBasket whereId($value)
     * @method static Builder<static>|RamadanBasket whereInventoryId($value)
     * @method static Builder<static>|RamadanBasket whereQtyForFamily($value)
     * @method static Builder<static>|RamadanBasket whereStatus($value)
     * @method static Builder<static>|RamadanBasket whereTenantId($value)
     * @method static Builder<static>|RamadanBasket whereUpdatedAt($value)
     */
    class RamadanBasket extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $uuid
     * @property string $name
     * @property string $guard_name
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read Tenant $tenant
     * @property-read Collection<int, User> $users
     * @property-read int|null $users_count
     *
     * @method static Builder<static>|Role newModelQuery()
     * @method static Builder<static>|Role newQuery()
     * @method static Builder<static>|Role permission($permissions, $without = false)
     * @method static Builder<static>|Role query()
     * @method static Builder<static>|Role whereCreatedAt($value)
     * @method static Builder<static>|Role whereGuardName($value)
     * @method static Builder<static>|Role whereName($value)
     * @method static Builder<static>|Role whereTenantId($value)
     * @method static Builder<static>|Role whereUpdatedAt($value)
     * @method static Builder<static>|Role whereUuid($value)
     * @method static Builder<static>|Role withoutPermission($permissions)
     */
    class Role extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property int $city_id
     * @property string $phase_key
     * @property string $e_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read City|null $city
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     *
     * @method static Builder<static>|School newModelQuery()
     * @method static Builder<static>|School newQuery()
     * @method static Builder<static>|School query()
     * @method static Builder<static>|School whereCityId($value)
     * @method static Builder<static>|School whereCreatedAt($value)
     * @method static Builder<static>|School whereEId($value)
     * @method static Builder<static>|School whereId($value)
     * @method static Builder<static>|School whereName($value)
     * @method static Builder<static>|School wherePhaseKey($value)
     * @method static Builder<static>|School whereUpdatedAt($value)
     */
    class School extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property int $id
     * @property string $name
     * @property float|null $min_price
     * @property float|null $max_price
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static Builder<static>|SchoolTool newModelQuery()
     * @method static Builder<static>|SchoolTool newQuery()
     * @method static Builder<static>|SchoolTool query()
     * @method static Builder<static>|SchoolTool whereCreatedAt($value)
     * @method static Builder<static>|SchoolTool whereId($value)
     * @method static Builder<static>|SchoolTool whereMaxPrice($value)
     * @method static Builder<static>|SchoolTool whereMinPrice($value)
     * @method static Builder<static>|SchoolTool whereName($value)
     * @method static Builder<static>|SchoolTool whereUpdatedAt($value)
     */
    class SchoolTool extends Eloquent {}
}

namespace App\Models{use Database\Factories\SecondSponsorFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string|null $first_name
     * @property string|null $last_name
     * @property string|null $degree_of_kinship
     * @property string|null $phone_number
     * @property string|null $address
     * @property float|null $income
     * @property string|null $family_id
     * @property string $tenant_id
     * @property bool $with_family
     * @property Carbon|null $deleted_at
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Tenant $tenant
     *
     * @method static SecondSponsorFactory factory($count = null, $state = [])
     * @method static Builder<static>|SecondSponsor newModelQuery()
     * @method static Builder<static>|SecondSponsor newQuery()
     * @method static Builder<static>|SecondSponsor onlyTrashed()
     * @method static Builder<static>|SecondSponsor query()
     * @method static Builder<static>|SecondSponsor whereAddress($value)
     * @method static Builder<static>|SecondSponsor whereCreatedAt($value)
     * @method static Builder<static>|SecondSponsor whereDegreeOfKinship($value)
     * @method static Builder<static>|SecondSponsor whereDeletedAt($value)
     * @method static Builder<static>|SecondSponsor whereFamilyId($value)
     * @method static Builder<static>|SecondSponsor whereFirstName($value)
     * @method static Builder<static>|SecondSponsor whereId($value)
     * @method static Builder<static>|SecondSponsor whereIncome($value)
     * @method static Builder<static>|SecondSponsor whereLastName($value)
     * @method static Builder<static>|SecondSponsor wherePhoneNumber($value)
     * @method static Builder<static>|SecondSponsor whereTenantId($value)
     * @method static Builder<static>|SecondSponsor whereUpdatedAt($value)
     * @method static Builder<static>|SecondSponsor whereWithFamily($value)
     * @method static Builder<static>|SecondSponsor withTrashed()
     * @method static Builder<static>|SecondSponsor withoutTrashed()
     */
    class SecondSponsor extends Eloquent {}
}

namespace App\Models{use Database\Factories\SettingsFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $user_id
     * @property string $locale
     * @property string $theme
     * @property string $color_scheme
     * @property string $layout
     * @property string $appearance
     * @property string $font_size
     * @property array<array-key, mixed>|null $notifications
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Tenant $tenant
     * @property-read User $user
     *
     * @method static SettingsFactory factory($count = null, $state = [])
     * @method static Builder<static>|Settings newModelQuery()
     * @method static Builder<static>|Settings newQuery()
     * @method static Builder<static>|Settings query()
     * @method static Builder<static>|Settings whereAppearance($value)
     * @method static Builder<static>|Settings whereColorScheme($value)
     * @method static Builder<static>|Settings whereCreatedAt($value)
     * @method static Builder<static>|Settings whereFontSize($value)
     * @method static Builder<static>|Settings whereId($value)
     * @method static Builder<static>|Settings whereLayout($value)
     * @method static Builder<static>|Settings whereLocale($value)
     * @method static Builder<static>|Settings whereNotifications($value)
     * @method static Builder<static>|Settings whereTenantId($value)
     * @method static Builder<static>|Settings whereTheme($value)
     * @method static Builder<static>|Settings whereUpdatedAt($value)
     * @method static Builder<static>|Settings whereUserId($value)
     */
    class Settings extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property int $id
     * @property float|null $label
     *
     * @method static Builder<static>|ShoeSize newModelQuery()
     * @method static Builder<static>|ShoeSize newQuery()
     * @method static Builder<static>|ShoeSize query()
     * @method static Builder<static>|ShoeSize whereId($value)
     * @method static Builder<static>|ShoeSize whereLabel($value)
     */
    class ShoeSize extends Eloquent {}
}

namespace App\Models{use Database\Factories\SponsorFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
     */
    class Sponsor extends Eloquent implements HasMedia {}
}

namespace App\Models{use Database\Factories\SponsorshipFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property float $amount
     * @property string $benefactor_id
     * @property string $recipientable_type
     * @property string $recipientable_id
     * @property string $sponsorship_type
     * @property array<array-key, mixed>|null $shop
     * @property string $created_by
     * @property string|null $deleted_by
     * @property string|null $until
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property-read Benefactor|null $benefactor
     * @property-read User|null $creator
     * @property-read Model|Eloquent $recipientable
     * @property-read Tenant|null $tenant
     *
     * @method static SponsorshipFactory factory($count = null, $state = [])
     * @method static Builder<static>|Sponsorship newModelQuery()
     * @method static Builder<static>|Sponsorship newQuery()
     * @method static Builder<static>|Sponsorship onlyTrashed()
     * @method static Builder<static>|Sponsorship query()
     * @method static Builder<static>|Sponsorship whereAmount($value)
     * @method static Builder<static>|Sponsorship whereBenefactorId($value)
     * @method static Builder<static>|Sponsorship whereCreatedAt($value)
     * @method static Builder<static>|Sponsorship whereCreatedBy($value)
     * @method static Builder<static>|Sponsorship whereDeletedAt($value)
     * @method static Builder<static>|Sponsorship whereDeletedBy($value)
     * @method static Builder<static>|Sponsorship whereId($value)
     * @method static Builder<static>|Sponsorship whereRecipientableId($value)
     * @method static Builder<static>|Sponsorship whereRecipientableType($value)
     * @method static Builder<static>|Sponsorship whereShop($value)
     * @method static Builder<static>|Sponsorship whereSponsorshipType($value)
     * @method static Builder<static>|Sponsorship whereTenantId($value)
     * @method static Builder<static>|Sponsorship whereUntil($value)
     * @method static Builder<static>|Sponsorship whereUpdatedAt($value)
     * @method static Builder<static>|Sponsorship withTrashed()
     * @method static Builder<static>|Sponsorship withoutTrashed()
     */
    class Sponsorship extends Eloquent {}
}

namespace App\Models{use Database\Factories\SpouseFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

    /**
     * @property string $id
     * @property string $first_name
     * @property string $last_name
     * @property Carbon $birth_date
     * @property Carbon $death_date
     * @property string|null $function
     * @property float|null $income
     * @property string $type
     * @property string $family_id
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Family $family
     * @property-read MediaCollection<int, Media> $media
     * @property-read int|null $media_count
     * @property-read Tenant $tenant
     *
     * @method static SpouseFactory factory($count = null, $state = [])
     * @method static Builder<static>|Spouse newModelQuery()
     * @method static Builder<static>|Spouse newQuery()
     * @method static Builder<static>|Spouse query()
     * @method static Builder<static>|Spouse whereBirthDate($value)
     * @method static Builder<static>|Spouse whereCreatedAt($value)
     * @method static Builder<static>|Spouse whereDeathDate($value)
     * @method static Builder<static>|Spouse whereFamilyId($value)
     * @method static Builder<static>|Spouse whereFirstName($value)
     * @method static Builder<static>|Spouse whereFunction($value)
     * @method static Builder<static>|Spouse whereId($value)
     * @method static Builder<static>|Spouse whereIncome($value)
     * @method static Builder<static>|Spouse whereLastName($value)
     * @method static Builder<static>|Spouse whereTenantId($value)
     * @method static Builder<static>|Spouse whereType($value)
     * @method static Builder<static>|Spouse whereUpdatedAt($value)
     */
    class Spouse extends Eloquent implements HasMedia {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property int $id
     * @property string $en_name
     * @property string $ar_name
     * @property string $fr_name
     * @property-read SubjectTranscript|null $pivot
     * @property-read Collection<int, Transcript> $transcripts
     * @property-read int|null $transcripts_count
     *
     * @method static Builder<static>|Subject newModelQuery()
     * @method static Builder<static>|Subject newQuery()
     * @method static Builder<static>|Subject query()
     * @method static Builder<static>|Subject whereArName($value)
     * @method static Builder<static>|Subject whereEnName($value)
     * @method static Builder<static>|Subject whereFrName($value)
     * @method static Builder<static>|Subject whereId($value)
     */
    class Subject extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property string $id
     * @property int $subject_id
     * @property float|null $grade
     * @property string $tenant_id
     * @property string $transcript_id
     * @property-read Tenant|null $tenant
     *
     * @method static Builder<static>|SubjectTranscript newModelQuery()
     * @method static Builder<static>|SubjectTranscript newQuery()
     * @method static Builder<static>|SubjectTranscript query()
     * @method static Builder<static>|SubjectTranscript whereGrade($value)
     * @method static Builder<static>|SubjectTranscript whereId($value)
     * @method static Builder<static>|SubjectTranscript whereSubjectId($value)
     * @method static Builder<static>|SubjectTranscript whereTenantId($value)
     * @method static Builder<static>|SubjectTranscript whereTranscriptId($value)
     */
    class SubjectTranscript extends Eloquent {}
}

namespace App\Models{use Database\Factories\TenantFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
    use Stancl\Tenancy\Contracts\TenantWithDatabase;
    use Stancl\Tenancy\Database\TenantCollection;

    /**
     * @property string $id
     * @property array<array-key, mixed>|null $data
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, Benefactor> $benefactors
     * @property-read int|null $benefactors_count
     * @property-read Collection<int, Branch> $branches
     * @property-read int|null $branches_count
     * @property-read Collection<int, \Stancl\Tenancy\Database\Models\Domain> $domains
     * @property-read int|null $domains_count
     * @property-read Collection<int, Family> $families
     * @property-read int|null $families_count
     * @property-read MediaCollection<int, Media> $media
     * @property-read int|null $media_count
     * @property-read Collection<int, User> $members
     * @property-read int|null $members_count
     * @property-read Collection<int, PrivateSchool> $schools
     * @property-read int|null $schools_count
     * @property-read Collection<int, Zone> $zones
     * @property-read int|null $zones_count
     *
     * @method static TenantCollection<int, static> all($columns = ['*'])
     * @method static TenantFactory factory($count = null, $state = [])
     * @method static TenantCollection<int, static> get($columns = ['*'])
     * @method static Builder<static>|Tenant newModelQuery()
     * @method static Builder<static>|Tenant newQuery()
     * @method static Builder<static>|Tenant query()
     * @method static Builder<static>|Tenant whereCreatedAt($value)
     * @method static Builder<static>|Tenant whereData($value)
     * @method static Builder<static>|Tenant whereId($value)
     * @method static Builder<static>|Tenant whereUpdatedAt($value)
     */
    class Tenant extends Eloquent implements HasMedia, TenantWithDatabase {}
}

namespace App\Models{use Database\Factories\TranscriptFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $trimester
     * @property string $orphan_id
     * @property string $tenant_id
     * @property string $academic_level_id
     * @property float $average
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read AcademicLevel|null $academicLevel
     * @property-read Orphan|null $orphan
     * @property-read SubjectTranscript|null $pivot
     * @property-read Collection<int, Subject> $subjects
     * @property-read int|null $subjects_count
     * @property-read Tenant|null $tenant
     *
     * @method static TranscriptFactory factory($count = null, $state = [])
     * @method static Builder<static>|Transcript newModelQuery()
     * @method static Builder<static>|Transcript newQuery()
     * @method static Builder<static>|Transcript query()
     * @method static Builder<static>|Transcript whereAcademicLevelId($value)
     * @method static Builder<static>|Transcript whereAverage($value)
     * @method static Builder<static>|Transcript whereCreatedAt($value)
     * @method static Builder<static>|Transcript whereId($value)
     * @method static Builder<static>|Transcript whereOrphanId($value)
     * @method static Builder<static>|Transcript whereTenantId($value)
     * @method static Builder<static>|Transcript whereTrimester($value)
     * @method static Builder<static>|Transcript whereUpdatedAt($value)
     */
    class Transcript extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property string $id
     * @property string $name
     * @property string $type
     * @property string|null $zone
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     *
     * @method static Builder<static>|University newModelQuery()
     * @method static Builder<static>|University newQuery()
     * @method static Builder<static>|University query()
     * @method static Builder<static>|University whereId($value)
     * @method static Builder<static>|University whereName($value)
     * @method static Builder<static>|University whereType($value)
     * @method static Builder<static>|University whereZone($value)
     */
    class University extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property int $id
     * @property string $speciality
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     *
     * @method static Builder<static>|UniversitySpeciality newModelQuery()
     * @method static Builder<static>|UniversitySpeciality newQuery()
     * @method static Builder<static>|UniversitySpeciality query()
     * @method static Builder<static>|UniversitySpeciality whereId($value)
     * @method static Builder<static>|UniversitySpeciality whereSpeciality($value)
     */
    class UniversitySpeciality extends Eloquent {}
}

namespace App\Models{use Database\Factories\UserFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Notifications\DatabaseNotification;
    use Illuminate\Notifications\DatabaseNotificationCollection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $first_name
     * @property string $last_name
     * @property string|null $phone
     * @property string|null $address
     * @property array<array-key, mixed>|null $location
     * @property string|null $workplace
     * @property string|null $function
     * @property string|null $zone_id
     * @property string|null $branch_id
     * @property string $email
     * @property string|null $gender
     * @property string|null $qualification
     * @property Carbon|null $email_verified_at
     * @property string $password
     * @property string|null $remember_token
     * @property string $tenant_id
     * @property string|null $academic_level_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string|null $deleted_by
     * @property string|null $created_by
     * @property Carbon|null $deleted_at
     * @property-read AcademicLevel|null $academicLevel
     * @property-read Branch|null $branch
     * @property-read CompetenceUser|CommitteeUser|null $pivot
     * @property-read Collection<int, Committee> $committees
     * @property-read int|null $committees_count
     * @property-read Collection<int, Competence> $competences
     * @property-read int|null $competences_count
     * @property-read User|null $creator
     * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read Collection<int, Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read Collection<int, Role> $roles
     * @property-read int|null $roles_count
     * @property-read Settings|null $settings
     * @property-read Tenant $tenant
     * @property-read Collection<int, PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     * @property-read Zone|null $zone
     *
     * @method static UserFactory factory($count = null, $state = [])
     * @method static Builder<static>|User newModelQuery()
     * @method static Builder<static>|User newQuery()
     * @method static Builder<static>|User onlyTrashed()
     * @method static Builder<static>|User permission($permissions, $without = false)
     * @method static Builder<static>|User query()
     * @method static Builder<static>|User role($roles, $guard = null, $without = false)
     * @method static Builder<static>|User whereAcademicLevelId($value)
     * @method static Builder<static>|User whereAddress($value)
     * @method static Builder<static>|User whereBranchId($value)
     * @method static Builder<static>|User whereCreatedAt($value)
     * @method static Builder<static>|User whereCreatedBy($value)
     * @method static Builder<static>|User whereDeletedAt($value)
     * @method static Builder<static>|User whereDeletedBy($value)
     * @method static Builder<static>|User whereEmail($value)
     * @method static Builder<static>|User whereEmailVerifiedAt($value)
     * @method static Builder<static>|User whereFirstName($value)
     * @method static Builder<static>|User whereFunction($value)
     * @method static Builder<static>|User whereGender($value)
     * @method static Builder<static>|User whereId($value)
     * @method static Builder<static>|User whereLastName($value)
     * @method static Builder<static>|User whereLocation($value)
     * @method static Builder<static>|User wherePassword($value)
     * @method static Builder<static>|User wherePhone($value)
     * @method static Builder<static>|User whereQualification($value)
     * @method static Builder<static>|User whereRememberToken($value)
     * @method static Builder<static>|User whereTenantId($value)
     * @method static Builder<static>|User whereUpdatedAt($value)
     * @method static Builder<static>|User whereWorkplace($value)
     * @method static Builder<static>|User whereZoneId($value)
     * @method static Builder<static>|User withTrashed()
     * @method static Builder<static>|User withoutPermission($permissions)
     * @method static Builder<static>|User withoutRole($roles, $guard = null)
     * @method static Builder<static>|User withoutTrashed()
     */
    class User extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $arabic_name
     * @property string $latin_name
     * @property string $code
     * @property string $wilaya_code
     * @property string $e_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     *
     * @method static Builder<static>|VocationalTrainingCenter newModelQuery()
     * @method static Builder<static>|VocationalTrainingCenter newQuery()
     * @method static Builder<static>|VocationalTrainingCenter query()
     * @method static Builder<static>|VocationalTrainingCenter whereArabicName($value)
     * @method static Builder<static>|VocationalTrainingCenter whereCode($value)
     * @method static Builder<static>|VocationalTrainingCenter whereCreatedAt($value)
     * @method static Builder<static>|VocationalTrainingCenter whereEId($value)
     * @method static Builder<static>|VocationalTrainingCenter whereId($value)
     * @method static Builder<static>|VocationalTrainingCenter whereLatinName($value)
     * @method static Builder<static>|VocationalTrainingCenter whereUpdatedAt($value)
     * @method static Builder<static>|VocationalTrainingCenter whereWilayaCode($value)
     */
    class VocationalTrainingCenter extends Eloquent {}
}

namespace App\Models{use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @property int $id
     * @property string $speciality
     * @property string $division
     * @property-read Collection<int, Orphan> $orphans
     * @property-read int|null $orphans_count
     *
     * @method static Builder<static>|VocationalTrainingSpeciality newModelQuery()
     * @method static Builder<static>|VocationalTrainingSpeciality newQuery()
     * @method static Builder<static>|VocationalTrainingSpeciality query()
     * @method static Builder<static>|VocationalTrainingSpeciality whereDivision($value)
     * @method static Builder<static>|VocationalTrainingSpeciality whereId($value)
     * @method static Builder<static>|VocationalTrainingSpeciality whereSpeciality($value)
     */
    class VocationalTrainingSpeciality extends Eloquent {}
}

namespace App\Models{use Database\Factories\ZoneFactory;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * @property string $id
     * @property string $name
     * @property string $description
     * @property array<array-key, mixed>|null $geom
     * @property string $tenant_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @property string $created_by
     * @property string|null $deleted_by
     * @property-read User $creator
     * @property-read Collection<int, Family> $families
     * @property-read int|null $families_count
     * @property-read Collection<int, User> $members
     * @property-read int|null $members_count
     * @property-read Tenant $tenant
     *
     * @method static ZoneFactory factory($count = null, $state = [])
     * @method static Builder<static>|Zone newModelQuery()
     * @method static Builder<static>|Zone newQuery()
     * @method static Builder<static>|Zone onlyTrashed()
     * @method static Builder<static>|Zone query()
     * @method static Builder<static>|Zone whereCreatedAt($value)
     * @method static Builder<static>|Zone whereCreatedBy($value)
     * @method static Builder<static>|Zone whereDeletedAt($value)
     * @method static Builder<static>|Zone whereDeletedBy($value)
     * @method static Builder<static>|Zone whereDescription($value)
     * @method static Builder<static>|Zone whereGeom($value)
     * @method static Builder<static>|Zone whereId($value)
     * @method static Builder<static>|Zone whereName($value)
     * @method static Builder<static>|Zone whereTenantId($value)
     * @method static Builder<static>|Zone whereUpdatedAt($value)
     * @method static Builder<static>|Zone withTrashed()
     * @method static Builder<static>|Zone withoutTrashed()
     */
    class Zone extends Eloquent {}
}
