<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

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
 *
 * @mixin Eloquent
 */
class University extends Model
{
    use HasUuids, Searchable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'zone',
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }
}
