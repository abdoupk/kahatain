<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, HasUuids;

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
