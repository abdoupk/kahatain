<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string|null $level
 * @property string|null $phase
 *
 * @method static Builder|AcademicLevel newModelQuery()
 * @method static Builder|AcademicLevel newQuery()
 * @method static Builder|AcademicLevel query()
 * @method static Builder|AcademicLevel whereId($value)
 * @method static Builder|AcademicLevel whereLevel($value)
 * @method static Builder|AcademicLevel wherePhase($value)
 *
 * @mixin Eloquent
 */
class AcademicLevel extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }

    public function subjects(): Collection
    {
        return Subject::whereIn('id', $this->subject_ids)
            ->get()->map(function (Subject $subject) {
                return [
                    'id' => $subject->id,
                    'name' => $subject->getName(),
                ];
            });
    }

    protected function casts(): array
    {
        return [
            'subject_ids' => 'array',
        ];
    }
}
