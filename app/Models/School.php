<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

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
