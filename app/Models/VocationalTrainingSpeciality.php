<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

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
 *
 * @mixin Eloquent
 */
class VocationalTrainingSpeciality extends Model
{
    use Searchable;

    public $timestamps = false;

    protected $fillable = [
        'speciality',
        'division',
    ];

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'speciality');
    }

    public function getName(): string
    {
        return $this->speciality;
    }
}
