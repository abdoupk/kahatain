<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }
}
