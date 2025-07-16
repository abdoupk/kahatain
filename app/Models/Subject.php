<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
