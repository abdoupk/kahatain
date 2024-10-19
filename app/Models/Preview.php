<?php

namespace App\Models;

use Database\Factories\PreviewFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
 * @property-read MemberPreview $pivot
 * @property-read Collection<int, User> $inspectors
 * @property-read int|null $inspectors_count
 * @property-read Tenant|null $tenant
 *
 * @method static PreviewFactory factory($count = null, $state = [])
 * @method static Builder|Preview newModelQuery()
 * @method static Builder|Preview newQuery()
 * @method static Builder|Preview onlyTrashed()
 * @method static Builder|Preview query()
 * @method static Builder|Preview whereCreatedAt($value)
 * @method static Builder|Preview whereDeletedAt($value)
 * @method static Builder|Preview whereFamilyId($value)
 * @method static Builder|Preview whereId($value)
 * @method static Builder|Preview wherePreviewDate($value)
 * @method static Builder|Preview whereReport($value)
 * @method static Builder|Preview whereTenantId($value)
 * @method static Builder|Preview whereUpdatedAt($value)
 * @method static Builder|Preview withTrashed()
 * @method static Builder|Preview withoutTrashed()
 *
 * @mixin Eloquent
 */
class Preview extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes, SoftDeletes;

    protected $table = 'previews';

    protected $fillable = [
        'report',
        'preview_date',
        'family_id',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function inspectors(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'member_preview',
            'preview_id',
            'user_id'
        )->using(MemberPreview::class);
    }

    public function searchableAs(): string
    {
        return 'previews';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['family', 'inspectors']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'report' => $this->report,
            'preview_date' => $this->preview_date,
            'family' => [
                'id' => $this->family_id,
                'name' => $this->family->name,
            ],
            'inspectors' => $this->inspectors->pluck('name')->toArray(),
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }

    protected function casts(): array
    {
        return [
            'preview_date' => 'date',
            'family_id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}
