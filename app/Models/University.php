<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class University extends Model
{
    use HasUuids, Searchable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'zone',
    ];
}
