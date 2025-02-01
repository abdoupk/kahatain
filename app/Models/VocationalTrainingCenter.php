<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * @property string $id
 * @property string $arabic_name
 * @property string $latin_name
 * @property string $code
 * @property string $wilaya_code
 * @property string $e_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Orphan> $orphans
 * @property-read int|null $orphans_count
 *
 * @method static Builder<static>|VocationalTrainingCenter newModelQuery()
 * @method static Builder<static>|VocationalTrainingCenter newQuery()
 * @method static Builder<static>|VocationalTrainingCenter query()
 * @method static Builder<static>|VocationalTrainingCenter whereArabicName($value)
 * @method static Builder<static>|VocationalTrainingCenter whereCode($value)
 * @method static Builder<static>|VocationalTrainingCenter whereCreatedAt($value)
 * @method static Builder<static>|VocationalTrainingCenter whereEId($value)
 * @method static Builder<static>|VocationalTrainingCenter whereId($value)
 * @method static Builder<static>|VocationalTrainingCenter whereLatinName($value)
 * @method static Builder<static>|VocationalTrainingCenter whereUpdatedAt($value)
 * @method static Builder<static>|VocationalTrainingCenter whereWilayaCode($value)
 *
 * @mixin Eloquent
 */
class VocationalTrainingCenter extends Model
{
    use HasUuids, Searchable;

    protected $fillable = [
        'latin_name',
        'arabic_name',
        'code',
        'wilaya_code',
        'e_id',
    ];

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }

    public function getName(): string
    {
        return app()->getLocale() === 'ar' ? $this->arabic_name : $this->latin_name;
    }
}
