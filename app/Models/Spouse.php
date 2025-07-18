<?php

namespace App\Models;

use Database\Factories\SpouseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
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
 *
 * @mixin Eloquent
 */
class Spouse extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'death_date',
        'function',
        'income',
        'family_id',
        'tenant_id',
        'type',
    ];

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
        ];
    }
}
