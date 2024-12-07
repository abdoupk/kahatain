<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class School extends Model
{
    use HasUuids, Searchable;

    protected $fillable = [
        'name',
        'phase_key',
        'city_id',
        'wilaya_code',
        'e_id',
    ];

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }

    public function getName()
    {
        return $this->name;
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }
}
