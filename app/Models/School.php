<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
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

    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }
}
