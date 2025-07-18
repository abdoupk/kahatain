<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

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
 *
 * @mixin Eloquent
 */
class School extends Model
{
    use HasUuids, Searchable;

    protected $fillable = [
        'name',
        'phase_key',
        'city_id',
        'e_id',
    ];

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load('city');
    }

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getName()
    {
        return $this->name;
    }

    public function searchableAs(): string
    {
        return 'schools';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phase_key' => $this->phase_key,
            'city_id' => $this->city_id,
            'city' => [
                'id' => $this->city_id,
                'wilaya_code' => $this->city->wilaya_code,
                'commune_name_ascii' => $this->city->commune_name_ascii,
                'commune_name' => $this->city->commune_name,
            ],
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }
}
