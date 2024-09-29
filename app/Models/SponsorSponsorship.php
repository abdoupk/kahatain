<?php

namespace App\Models;

use Database\Factories\SponsorSponsorshipFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 *
 *
 * @property string $id
 * @property string $sponsor_id
 * @property string|null $medical_sponsorship
 * @property string|null $literacy_lessons
 * @property float|null $direct_sponsorship
 * @property string|null $project_support
 * @property string $tenant_id
 * @property string|null $created_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_at
 * @property-read Sponsor $sponsor
 * @property-read Tenant $tenant
 * @method static SponsorSponsorshipFactory factory($count = null, $state = [])
 * @method static Builder|SponsorSponsorship newModelQuery()
 * @method static Builder|SponsorSponsorship newQuery()
 * @method static Builder|SponsorSponsorship onlyTrashed()
 * @method static Builder|SponsorSponsorship query()
 * @method static Builder|SponsorSponsorship whereCreatedAt($value)
 * @method static Builder|SponsorSponsorship whereDeletedAt($value)
 * @method static Builder|SponsorSponsorship whereDirectSponsorship($value)
 * @method static Builder|SponsorSponsorship whereId($value)
 * @method static Builder|SponsorSponsorship whereLiteracyLessons($value)
 * @method static Builder|SponsorSponsorship whereMedicalSponsorship($value)
 * @method static Builder|SponsorSponsorship whereProjectSupport($value)
 * @method static Builder|SponsorSponsorship whereSponsorId($value)
 * @method static Builder|SponsorSponsorship whereTenantId($value)
 * @method static Builder|SponsorSponsorship whereUpdatedAt($value)
 * @method static Builder|SponsorSponsorship withTrashed()
 * @method static Builder|SponsorSponsorship withoutTrashed()
 * @mixin Eloquent
 */
class SponsorSponsorship extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'sponsor_id',
        'medical_sponsorship',
        'literacy_lessons',
        'direct_sponsorship',
        'project_support',
    ];

    protected $table = 'sponsor_sponsorship';

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function searchableAs(): string
    {
        return 'sponsor_sponsorships';
    }
}
