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
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 *
 * @method static Builder<static>|UniversitySpeciality newModelQuery()
 * @method static Builder<static>|UniversitySpeciality newQuery()
 * @method static Builder<static>|UniversitySpeciality query()
 * @method static Builder<static>|UniversitySpeciality whereId($value)
 * @method static Builder<static>|UniversitySpeciality whereSpeciality($value)
 *
 * @mixin Eloquent
 */
class UniversitySpeciality extends Model
{
    use Searchable;

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'speciality');
    }

    public function getName()
    {
        return $this->speciality;
    }
}
