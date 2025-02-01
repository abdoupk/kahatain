<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string|null $en_name
 * @property string|null $ar_name
 * @property string|null $fr_name
 *
 * @method static Builder|Subject newModelQuery()
 * @method static Builder|Subject newQuery()
 * @method static Builder|Subject query()
 * @method static Builder|Subject whereArName($value)
 * @method static Builder|Subject whereEnName($value)
 * @method static Builder|Subject whereFrName($value)
 * @method static Builder|Subject whereId($value)
 *
 * @property-read SubjectTranscript|null $pivot
 * @property-read Collection<int, Transcript> $transcripts
 * @property-read int|null $transcripts_count
 *
 * @mixin Eloquent
 */
class Subject extends Model
{
    public function getName(): string
    {
        return $this[app()->getLocale().'_name'];
    }

    public function transcripts(): BelongsToMany
    {
        return $this->belongsToMany(Transcript::class)->using(SubjectTranscript::class);
    }
}
